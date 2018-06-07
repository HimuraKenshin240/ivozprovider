<?php

namespace Agi\Action;
use Agi\ChannelInfo;
use Agi\Wrapper;
use Doctrine\ORM\EntityManagerInterface;
use Ivoz\Provider\Domain\Model\Ddi\DdiInterface;
use Ivoz\Provider\Domain\Model\Feature\Feature;
use Ivoz\Provider\Domain\Model\Friend\FriendInterface;

/**
 * @class ExternalFriendCallAction
 *
 * @brief Manage outgoing external calls generated by a friendly trunk
 *
 */
class ExternalFriendCallAction extends ExternalCallAction
{
    /**
     * @var FriendInterface
     */
    protected $friend;

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
     * @param FriendInterface|null $friend
     * @return $this
     */
    public function setFriend(FriendInterface $friend = null)
    {
        $this->friend = $friend;
        return $this;
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
        $friend = $this->friend;
        $number = $this->number;

        if (is_null($friend) || empty($number)) {
            $this->agi->error("Friend is not properly defined. Check configuration.");
            return;
        }

        // Get company from the caller
        $company = $friend->getCompany();

        // Some feedback for asterisk cli
        $this->agi->notice("Processing External call from \e[0;36m%s\e[0;93m to %s", $friend, $number);

        // Check if the diversion header contains a valid number
        $this->checkDiversionNumber($company, $number);

        // Check the user has this call allowed in its ACL
        if ($this->checkACL && !$friend->isAllowedToCall($number)) {
            $this->agi->error("User is not allowed to call %s", $number);
            // Play error notification over progress
            if ($company->hasFeature(Feature::PROGRESS)) {
                $this->agi->progress("ivozprovider/notAllowed");
            }
            $this->agi->decline();
            return;
        }

        if (!isset($ddi)) {
            // Allow identification from any company DDI
            $callerIdNum = $this->agi->getCallerIdNum();
            /** @var DdiInterface[] $companyDDIs */
            $companyDDIs = $friend->getCompany()->getDDIs();
            foreach ($companyDDIs as $companyDDI) {
                if ($callerIdNum === $companyDDI->getDDIE164()) {
                    $ddi = $companyDDI;
                    $this->agi->notice("Friend \e[0;36m%s\e[0;93m presented origin matches company DDI %s.", $friend, $ddi);
                    $this->agi->setCallerIdNum($ddi->getDDIE164());
                    break;
                }
            }
        }

        // Use fallback outgoing DDI
        if (!isset($ddi) || !$ddi) {
            $callerIdNum = $this->agi->getCallerIdNum();
            $ddi = $friend->getOutgoingDDI();
            if ($ddi) {
                $this->agi->notice(
                    "Using fallback DDI %s for friend \e[0;36m%s\e[0;93m because %s does not match any DDI.",
                    $ddi,
                    $friend,
                    $callerIdNum
                );

                $this->agi->setCallerIdNum($ddi->getDdie164());
            }
        }

        // Update caller displayed number
        if (!$ddi) {
            $this->agi->error("Friend \e[0;36m%s\e[0;93m has not OutgoingDDI configured",  $friend);
            $this->agi->decline();
            return;
        }

        // Check if DDI has recordings enabled
        $this->checkDDIRecording($ddi);

        // Call the PSJIP endpoint
        $this->agi->setVariable("DIAL_DST", "PJSIP/" . $number . '@proxytrunks');
        $this->agi->setVariable("DIAL_OPTS", "");
        $this->agi->setVariable("DIAL_TIMEOUT", "");
        $this->agi->redirect('call-world', $number);
    }
}
