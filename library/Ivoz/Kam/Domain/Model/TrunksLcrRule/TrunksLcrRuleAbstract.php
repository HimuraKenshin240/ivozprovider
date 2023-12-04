<?php

declare(strict_types=1);

namespace Ivoz\Kam\Domain\Model\TrunksLcrRule;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\RoutingPattern\RoutingPatternInterface;
use Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern\RoutingPatternGroupsRelPatternInterface;
use Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingInterface;
use Ivoz\Provider\Domain\Model\RoutingPattern\RoutingPattern;
use Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern\RoutingPatternGroupsRelPattern;
use Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRouting;

/**
* TrunksLcrRuleAbstract
* @codeCoverageIgnore
*/
abstract class TrunksLcrRuleAbstract
{
    use ChangelogTrait;

    /**
     * @var int
     * column: lcr_id
     */
    protected $lcrId = 1;

    /**
     * @var ?string
     */
    protected $prefix = null;

    /**
     * @var ?string
     * column: from_uri
     */
    protected $fromUri = null;

    /**
     * @var ?string
     * column: request_uri
     */
    protected $requestUri = null;

    /**
     * @var ?string
     * column: mt_tvalue
     */
    protected $mtTvalue = null;

    /**
     * @var int
     */
    protected $stopper = 0;

    /**
     * @var int
     */
    protected $enabled = 1;

    /**
     * @var ?RoutingPatternInterface
     * inversedBy lcrRules
     */
    protected $routingPattern = null;

    /**
     * @var ?RoutingPatternGroupsRelPatternInterface
     */
    protected $routingPatternGroupsRelPattern = null;

    /**
     * @var OutgoingRoutingInterface
     * inversedBy lcrRules
     */
    protected $outgoingRouting;

    /**
     * Constructor
     */
    protected function __construct(
        int $lcrId,
        int $stopper,
        int $enabled
    ) {
        $this->setLcrId($lcrId);
        $this->setStopper($stopper);
        $this->setEnabled($enabled);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "TrunksLcrRule",
            (string) $this->getId()
        );
    }

    /**
     * @throws \Exception
     */
    protected function sanitizeValues(): void
    {
    }

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): TrunksLcrRuleDto
    {
        return new TrunksLcrRuleDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|TrunksLcrRuleInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TrunksLcrRuleDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, TrunksLcrRuleInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TrunksLcrRuleDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, TrunksLcrRuleDto::class);
        $lcrId = $dto->getLcrId();
        Assertion::notNull($lcrId, 'getLcrId value is null, but non null value was expected.');
        $stopper = $dto->getStopper();
        Assertion::notNull($stopper, 'getStopper value is null, but non null value was expected.');
        $enabled = $dto->getEnabled();
        Assertion::notNull($enabled, 'getEnabled value is null, but non null value was expected.');
        $outgoingRouting = $dto->getOutgoingRouting();
        Assertion::notNull($outgoingRouting, 'getOutgoingRouting value is null, but non null value was expected.');

        $self = new static(
            $lcrId,
            $stopper,
            $enabled
        );

        $self
            ->setPrefix($dto->getPrefix())
            ->setFromUri($dto->getFromUri())
            ->setRequestUri($dto->getRequestUri())
            ->setMtTvalue($dto->getMtTvalue())
            ->setRoutingPattern($fkTransformer->transform($dto->getRoutingPattern()))
            ->setRoutingPatternGroupsRelPattern($fkTransformer->transform($dto->getRoutingPatternGroupsRelPattern()))
            ->setOutgoingRouting($fkTransformer->transform($outgoingRouting));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param TrunksLcrRuleDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, TrunksLcrRuleDto::class);

        $lcrId = $dto->getLcrId();
        Assertion::notNull($lcrId, 'getLcrId value is null, but non null value was expected.');
        $stopper = $dto->getStopper();
        Assertion::notNull($stopper, 'getStopper value is null, but non null value was expected.');
        $enabled = $dto->getEnabled();
        Assertion::notNull($enabled, 'getEnabled value is null, but non null value was expected.');
        $outgoingRouting = $dto->getOutgoingRouting();
        Assertion::notNull($outgoingRouting, 'getOutgoingRouting value is null, but non null value was expected.');

        $this
            ->setLcrId($lcrId)
            ->setPrefix($dto->getPrefix())
            ->setFromUri($dto->getFromUri())
            ->setRequestUri($dto->getRequestUri())
            ->setMtTvalue($dto->getMtTvalue())
            ->setStopper($stopper)
            ->setEnabled($enabled)
            ->setRoutingPattern($fkTransformer->transform($dto->getRoutingPattern()))
            ->setRoutingPatternGroupsRelPattern($fkTransformer->transform($dto->getRoutingPatternGroupsRelPattern()))
            ->setOutgoingRouting($fkTransformer->transform($outgoingRouting));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TrunksLcrRuleDto
    {
        return self::createDto()
            ->setLcrId(self::getLcrId())
            ->setPrefix(self::getPrefix())
            ->setFromUri(self::getFromUri())
            ->setRequestUri(self::getRequestUri())
            ->setMtTvalue(self::getMtTvalue())
            ->setStopper(self::getStopper())
            ->setEnabled(self::getEnabled())
            ->setRoutingPattern(RoutingPattern::entityToDto(self::getRoutingPattern(), $depth))
            ->setRoutingPatternGroupsRelPattern(RoutingPatternGroupsRelPattern::entityToDto(self::getRoutingPatternGroupsRelPattern(), $depth))
            ->setOutgoingRouting(OutgoingRouting::entityToDto(self::getOutgoingRouting(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'lcr_id' => self::getLcrId(),
            'prefix' => self::getPrefix(),
            'from_uri' => self::getFromUri(),
            'request_uri' => self::getRequestUri(),
            'mt_tvalue' => self::getMtTvalue(),
            'stopper' => self::getStopper(),
            'enabled' => self::getEnabled(),
            'routingPatternId' => self::getRoutingPattern()?->getId(),
            'routingPatternGroupsRelPatternId' => self::getRoutingPatternGroupsRelPattern()?->getId(),
            'outgoingRoutingId' => self::getOutgoingRouting()->getId()
        ];
    }

    protected function setLcrId(int $lcrId): static
    {
        Assertion::greaterOrEqualThan($lcrId, 0, 'lcrId provided "%s" is not greater or equal than "%s".');

        $this->lcrId = $lcrId;

        return $this;
    }

    public function getLcrId(): int
    {
        return $this->lcrId;
    }

    protected function setPrefix(?string $prefix = null): static
    {
        if (!is_null($prefix)) {
            Assertion::maxLength($prefix, 100, 'prefix value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    protected function setFromUri(?string $fromUri = null): static
    {
        if (!is_null($fromUri)) {
            Assertion::maxLength($fromUri, 255, 'fromUri value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->fromUri = $fromUri;

        return $this;
    }

    public function getFromUri(): ?string
    {
        return $this->fromUri;
    }

    protected function setRequestUri(?string $requestUri = null): static
    {
        if (!is_null($requestUri)) {
            Assertion::maxLength($requestUri, 100, 'requestUri value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->requestUri = $requestUri;

        return $this;
    }

    public function getRequestUri(): ?string
    {
        return $this->requestUri;
    }

    protected function setMtTvalue(?string $mtTvalue = null): static
    {
        if (!is_null($mtTvalue)) {
            Assertion::maxLength($mtTvalue, 128, 'mtTvalue value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->mtTvalue = $mtTvalue;

        return $this;
    }

    public function getMtTvalue(): ?string
    {
        return $this->mtTvalue;
    }

    protected function setStopper(int $stopper): static
    {
        Assertion::greaterOrEqualThan($stopper, 0, 'stopper provided "%s" is not greater or equal than "%s".');

        $this->stopper = $stopper;

        return $this;
    }

    public function getStopper(): int
    {
        return $this->stopper;
    }

    protected function setEnabled(int $enabled): static
    {
        Assertion::greaterOrEqualThan($enabled, 0, 'enabled provided "%s" is not greater or equal than "%s".');

        $this->enabled = $enabled;

        return $this;
    }

    public function getEnabled(): int
    {
        return $this->enabled;
    }

    public function setRoutingPattern(?RoutingPatternInterface $routingPattern = null): static
    {
        $this->routingPattern = $routingPattern;

        return $this;
    }

    public function getRoutingPattern(): ?RoutingPatternInterface
    {
        return $this->routingPattern;
    }

    protected function setRoutingPatternGroupsRelPattern(?RoutingPatternGroupsRelPatternInterface $routingPatternGroupsRelPattern = null): static
    {
        $this->routingPatternGroupsRelPattern = $routingPatternGroupsRelPattern;

        return $this;
    }

    public function getRoutingPatternGroupsRelPattern(): ?RoutingPatternGroupsRelPatternInterface
    {
        return $this->routingPatternGroupsRelPattern;
    }

    public function setOutgoingRouting(OutgoingRoutingInterface $outgoingRouting): static
    {
        $this->outgoingRouting = $outgoingRouting;

        return $this;
    }

    public function getOutgoingRouting(): OutgoingRoutingInterface
    {
        return $this->outgoingRouting;
    }
}
