<?php

namespace Agi\Action;
use Agi\ChannelInfo;
use Agi\Wrapper;
use Doctrine\ORM\EntityManagerInterface;
use Ivoz\Provider\Domain\Model\Feature\Feature;
use Ivoz\Provider\Domain\Model\OutgoingDdiRule\OutgoingDdiRuleInterface;
use Ivoz\Provider\Domain\Model\User\UserInterface;

/**
 * @class ExternalUserCallAction
 *
 * @brief Manage outgoing external calls generated by an user
 *
 */
class ExternalUserCallAction extends ExternalCallAction
{
    /**
     * Destination number in E.164 format
     *
     * @var string
     */
    protected $number;

    /**
     * Determine if User ACL will be checked
     * @var bool
     */
    protected $checkACL = true;

    /**
     * ExternalUserCallAction constructor.
     * @param Wrapper $agi
     * @param ChannelInfo $channelInfo
     * @param EntityManagerInterface $em
     */
    public function __construct(
        Wrapper $agi,
        ChannelInfo $channelInfo,
        EntityManagerInterface $em
    )
    {
        parent::__construct($agi, $channelInfo, $em);
    }

    /**
     * @param string|null $number
     * @return $this
     */
    public function setDestination(string $number = null)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @param bool $checkACL
     * @return $this
     */
    public function setCheckACL(bool $checkACL = true)
    {
        $this->checkACL = $checkACL;
        return $this;
    }

    public function process()
    {
        // Local variables
        /** @var UserInterface $user */
        $user = $this->channelInfo->getChannelCaller();
        $origin = $this->channelInfo->getChannelOrigin();
        $number = $this->number;

        // Get company from the caller
        $company = $user->getCompany();

        // Some feedback for asterisk cli
        $this->agi->notice("Processing External call from <green>%s</green> to %s", $user, $number);

        // Check the user has this call allowed in its ACL
        if ($this->checkACL == false) {
            $this->agi->verbose("Skipping ACL checks for this call.");

        } else if (!$user->isAllowedToCall($number)) {
            $this->agi->error("User is not allowed to call %s", $number);
            // Play error notification over progress
            if ($company->hasFeature(Feature::PROGRESS)) {
                $this->agi->progress("ivozprovider/notAllowed");
            }
            $this->agi->decline();
            return;
        }

        // Check Caller DDI
        $ddi = $this->getCallerOutgoingDDI($number);
        if (!$ddi) {
            $this->agi->error("User %s has not OutgoingDDI configured", $user);
            $this->agi->decline();
            return;
        }

        // Update Origin persentation
        if (!$this->checkValidOrigin($number)) {
            $this->agi->error("Origin %s has no outgoingDDI number assigned.",  $origin);
            $this->agi->decline();
            return;
        }

        // Check if the diversion header contains a valid number
        $this->checkDiversionNumber($company, $number);
        // Check if DDI has recordings enabled
        $this->checkDDIRecording($ddi);

        // We need Outgoing DDI for external call presentation
        if (!$ddi) {
            $this->agi->error("User <green>%s</green> has not OutgoingDDI configured", $user);
            $this->agi->decline();
            return;
        }

        // Dial Options
        $options = "";

        // For record asterisk builtin feature code (FIXME Dont use both X's)
        if ($user->getCompany()->getOnDemandRecord() == 2) {
            $options .= "xX";
        }

        // Call the PSJIP endpoint
        $this->agi->setVariable("DIAL_DST", "PJSIP/" . $number . '@proxytrunks');
        $this->agi->setVariable("DIAL_OPTS", $options);
        $this->agi->setVariable("DIAL_TIMEOUT", "");
        $this->agi->redirect('call-world', $number);
    }

    public function getCallerOutgoingDDI($number)
    {
        // User making this call
        $caller = $this->channelInfo->getChannelCaller();

        // Get default user outgoing DDI
        $ddi = $caller->getOutgoingDDI();

        // If user has OutgoingDDI rules, check if we have to override current DDI
        /** @var OutgoingDdiRuleInterface $outgoingDDIRule */
        $outgoingDDIRule = $caller->getOutgoingDDIRule();
        if ($outgoingDDIRule) {
            $this->agi->verbose("Checking CALLER %s outgoingDDI rules %s for destination %s",  $caller, $outgoingDDIRule, $number);

            $ddi = $outgoingDDIRule->getOutgoingDDI($ddi, $number);
            if ($ddi && $ddi != $caller->getOutgoingDDI()) {
                $this->agi->notice("Rule %s changed presented DDI to %s", $outgoingDDIRule, $ddi);
            }
        }

        return $ddi;
    }
}
