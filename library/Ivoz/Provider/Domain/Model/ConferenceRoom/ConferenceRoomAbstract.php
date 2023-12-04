<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\ConferenceRoom;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\Company;

/**
* ConferenceRoomAbstract
* @codeCoverageIgnore
*/
abstract class ConferenceRoomAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $pinProtected = false;

    /**
     * @var ?string
     */
    protected $pinCode = null;

    /**
     * @var int
     */
    protected $maxMembers = 0;

    /**
     * @var string
     * comment: enum:always|first
     */
    protected $announceUserCount = 'first';

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * Constructor
     */
    protected function __construct(
        string $name,
        bool $pinProtected,
        int $maxMembers,
        string $announceUserCount
    ) {
        $this->setName($name);
        $this->setPinProtected($pinProtected);
        $this->setMaxMembers($maxMembers);
        $this->setAnnounceUserCount($announceUserCount);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "ConferenceRoom",
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
    public static function createDto($id = null): ConferenceRoomDto
    {
        return new ConferenceRoomDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|ConferenceRoomInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?ConferenceRoomDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, ConferenceRoomInterface::class);

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
     * @param ConferenceRoomDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, ConferenceRoomDto::class);
        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $pinProtected = $dto->getPinProtected();
        Assertion::notNull($pinProtected, 'getPinProtected value is null, but non null value was expected.');
        $maxMembers = $dto->getMaxMembers();
        Assertion::notNull($maxMembers, 'getMaxMembers value is null, but non null value was expected.');
        $announceUserCount = $dto->getAnnounceUserCount();
        Assertion::notNull($announceUserCount, 'getAnnounceUserCount value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $self = new static(
            $name,
            $pinProtected,
            $maxMembers,
            $announceUserCount
        );

        $self
            ->setPinCode($dto->getPinCode())
            ->setCompany($fkTransformer->transform($company));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ConferenceRoomDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, ConferenceRoomDto::class);

        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $pinProtected = $dto->getPinProtected();
        Assertion::notNull($pinProtected, 'getPinProtected value is null, but non null value was expected.');
        $maxMembers = $dto->getMaxMembers();
        Assertion::notNull($maxMembers, 'getMaxMembers value is null, but non null value was expected.');
        $announceUserCount = $dto->getAnnounceUserCount();
        Assertion::notNull($announceUserCount, 'getAnnounceUserCount value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $this
            ->setName($name)
            ->setPinProtected($pinProtected)
            ->setPinCode($dto->getPinCode())
            ->setMaxMembers($maxMembers)
            ->setAnnounceUserCount($announceUserCount)
            ->setCompany($fkTransformer->transform($company));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): ConferenceRoomDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setPinProtected(self::getPinProtected())
            ->setPinCode(self::getPinCode())
            ->setMaxMembers(self::getMaxMembers())
            ->setAnnounceUserCount(self::getAnnounceUserCount())
            ->setCompany(Company::entityToDto(self::getCompany(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'name' => self::getName(),
            'pinProtected' => self::getPinProtected(),
            'pinCode' => self::getPinCode(),
            'maxMembers' => self::getMaxMembers(),
            'announceUserCount' => self::getAnnounceUserCount(),
            'companyId' => self::getCompany()->getId()
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 50, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setPinProtected(bool $pinProtected): static
    {
        $this->pinProtected = $pinProtected;

        return $this;
    }

    public function getPinProtected(): bool
    {
        return $this->pinProtected;
    }

    protected function setPinCode(?string $pinCode = null): static
    {
        if (!is_null($pinCode)) {
            Assertion::maxLength($pinCode, 6, 'pinCode value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->pinCode = $pinCode;

        return $this;
    }

    public function getPinCode(): ?string
    {
        return $this->pinCode;
    }

    protected function setMaxMembers(int $maxMembers): static
    {
        Assertion::greaterOrEqualThan($maxMembers, 0, 'maxMembers provided "%s" is not greater or equal than "%s".');

        $this->maxMembers = $maxMembers;

        return $this;
    }

    public function getMaxMembers(): int
    {
        return $this->maxMembers;
    }

    protected function setAnnounceUserCount(string $announceUserCount): static
    {
        Assertion::maxLength($announceUserCount, 10, 'announceUserCount value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        Assertion::choice(
            $announceUserCount,
            [
                ConferenceRoomInterface::ANNOUNCEUSERCOUNT_ALWAYS,
                ConferenceRoomInterface::ANNOUNCEUSERCOUNT_FIRST,
            ],
            'announceUserCountvalue "%s" is not an element of the valid values: %s'
        );

        $this->announceUserCount = $announceUserCount;

        return $this;
    }

    public function getAnnounceUserCount(): string
    {
        return $this->announceUserCount;
    }

    protected function setCompany(CompanyInterface $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }
}
