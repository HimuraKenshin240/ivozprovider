<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\RouteLock;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\Company;

/**
* RouteLockAbstract
* @codeCoverageIgnore
*/
abstract class RouteLockAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var bool
     */
    protected $open = true;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * Constructor
     */
    protected function __construct(
        string $name,
        string $description,
        bool $open
    ) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setOpen($open);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "RouteLock",
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
    public static function createDto($id = null): RouteLockDto
    {
        return new RouteLockDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|RouteLockInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?RouteLockDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, RouteLockInterface::class);

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
     * @param RouteLockDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, RouteLockDto::class);
        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $description = $dto->getDescription();
        Assertion::notNull($description, 'getDescription value is null, but non null value was expected.');
        $open = $dto->getOpen();
        Assertion::notNull($open, 'getOpen value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $self = new static(
            $name,
            $description,
            $open
        );

        $self
            ->setCompany($fkTransformer->transform($company));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param RouteLockDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, RouteLockDto::class);

        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $description = $dto->getDescription();
        Assertion::notNull($description, 'getDescription value is null, but non null value was expected.');
        $open = $dto->getOpen();
        Assertion::notNull($open, 'getOpen value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $this
            ->setName($name)
            ->setDescription($description)
            ->setOpen($open)
            ->setCompany($fkTransformer->transform($company));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): RouteLockDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setDescription(self::getDescription())
            ->setOpen(self::getOpen())
            ->setCompany(Company::entityToDto(self::getCompany(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'name' => self::getName(),
            'description' => self::getDescription(),
            'open' => self::getOpen(),
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

    protected function setDescription(string $description): static
    {
        Assertion::maxLength($description, 100, 'description value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function setOpen(bool $open): static
    {
        $this->open = $open;

        return $this;
    }

    public function getOpen(): bool
    {
        return $this->open;
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
