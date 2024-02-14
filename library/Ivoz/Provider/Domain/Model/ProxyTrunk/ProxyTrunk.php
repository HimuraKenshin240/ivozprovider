<?php

namespace Ivoz\Provider\Domain\Model\ProxyTrunk;

use Ivoz\Core\Domain\Assert\Assertion;

/**
 * ProxyTrunk
 */
class ProxyTrunk extends ProxyTrunkAbstract implements ProxyTrunkInterface
{
    use ProxyTrunkTrait;

    public const MAIN_ADDRESS_ID = 1;

    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array
    {
        return parent::getChangeSet();
    }

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return static
     */
    protected function setIp(string $ip): static
    {
        try {
            Assertion::ip($ip);
        } catch (\Exception $e) {
            throw new \DomainException('Invalid IP address, discarding value.', 70000, $e);
        }

        return parent::setIp($ip);
    }

    protected function setAdvertisedIp(?string $advertisedIp = null): static
    {
        if (!is_null($advertisedIp)) {
            Assertion::ip($advertisedIp);
        }

        return parent::setAdvertisedIp($advertisedIp);
    }
}
