<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\Domain;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* DomainAbstract
* @codeCoverageIgnore
*/
abstract class DomainAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     * comment: enum:proxyusers|proxytrunks
     */
    protected $pointsTo = 'proxyusers';

    /**
     * @var ?string
     */
    protected $description = null;

    /**
     * Constructor
     */
    protected function __construct(
        string $domain,
        string $pointsTo
    ) {
        $this->setDomain($domain);
        $this->setPointsTo($pointsTo);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "Domain",
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
    public static function createDto($id = null): DomainDto
    {
        return new DomainDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|DomainInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?DomainDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, DomainInterface::class);

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
     * @param DomainDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, DomainDto::class);
        $domain = $dto->getDomain();
        Assertion::notNull($domain, 'getDomain value is null, but non null value was expected.');
        $pointsTo = $dto->getPointsTo();
        Assertion::notNull($pointsTo, 'getPointsTo value is null, but non null value was expected.');

        $self = new static(
            $domain,
            $pointsTo
        );

        $self
            ->setDescription($dto->getDescription());

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param DomainDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, DomainDto::class);

        $domain = $dto->getDomain();
        Assertion::notNull($domain, 'getDomain value is null, but non null value was expected.');
        $pointsTo = $dto->getPointsTo();
        Assertion::notNull($pointsTo, 'getPointsTo value is null, but non null value was expected.');

        $this
            ->setDomain($domain)
            ->setPointsTo($pointsTo)
            ->setDescription($dto->getDescription());

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): DomainDto
    {
        return self::createDto()
            ->setDomain(self::getDomain())
            ->setPointsTo(self::getPointsTo())
            ->setDescription(self::getDescription());
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'domain' => self::getDomain(),
            'pointsTo' => self::getPointsTo(),
            'description' => self::getDescription()
        ];
    }

    protected function setDomain(string $domain): static
    {
        Assertion::maxLength($domain, 190, 'domain value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->domain = $domain;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    protected function setPointsTo(string $pointsTo): static
    {
        Assertion::maxLength($pointsTo, 25, 'pointsTo value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        Assertion::choice(
            $pointsTo,
            [
                DomainInterface::POINTSTO_PROXYUSERS,
                DomainInterface::POINTSTO_PROXYTRUNKS,
            ],
            'pointsTovalue "%s" is not an element of the valid values: %s'
        );

        $this->pointsTo = $pointsTo;

        return $this;
    }

    public function getPointsTo(): string
    {
        return $this->pointsTo;
    }

    protected function setDescription(?string $description = null): static
    {
        if (!is_null($description)) {
            Assertion::maxLength($description, 500, 'description value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
