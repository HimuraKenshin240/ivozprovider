<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\Language;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Language\Name;

/**
* LanguageAbstract
* @codeCoverageIgnore
*/
abstract class LanguageAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $iden;

    /**
     * @var Name
     */
    protected $name;

    /**
     * Constructor
     */
    protected function __construct(
        string $iden,
        Name $name
    ) {
        $this->setIden($iden);
        $this->name = $name;
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "Language",
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
    public static function createDto($id = null): LanguageDto
    {
        return new LanguageDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|LanguageInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?LanguageDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, LanguageInterface::class);

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
     * @param LanguageDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, LanguageDto::class);
        $nameEn = $dto->getNameEn();
        Assertion::notNull($nameEn, 'nameEn value is null, but non null value was expected.');
        $nameEs = $dto->getNameEs();
        Assertion::notNull($nameEs, 'nameEs value is null, but non null value was expected.');
        $nameCa = $dto->getNameCa();
        Assertion::notNull($nameCa, 'nameCa value is null, but non null value was expected.');
        $nameIt = $dto->getNameIt();
        Assertion::notNull($nameIt, 'nameIt value is null, but non null value was expected.');
        $iden = $dto->getIden();
        Assertion::notNull($iden, 'getIden value is null, but non null value was expected.');

        $name = new Name(
            $nameEn,
            $nameEs,
            $nameCa,
            $nameIt
        );

        $self = new static(
            $iden,
            $name
        );

        ;

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param LanguageDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, LanguageDto::class);

        $nameEn = $dto->getNameEn();
        Assertion::notNull($nameEn, 'nameEn value is null, but non null value was expected.');
        $nameEs = $dto->getNameEs();
        Assertion::notNull($nameEs, 'nameEs value is null, but non null value was expected.');
        $nameCa = $dto->getNameCa();
        Assertion::notNull($nameCa, 'nameCa value is null, but non null value was expected.');
        $nameIt = $dto->getNameIt();
        Assertion::notNull($nameIt, 'nameIt value is null, but non null value was expected.');
        $iden = $dto->getIden();
        Assertion::notNull($iden, 'getIden value is null, but non null value was expected.');

        $name = new Name(
            $nameEn,
            $nameEs,
            $nameCa,
            $nameIt
        );

        $this
            ->setIden($iden)
            ->setName($name);

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): LanguageDto
    {
        return self::createDto()
            ->setIden(self::getIden())
            ->setNameEn(self::getName()->getEn())
            ->setNameEs(self::getName()->getEs())
            ->setNameCa(self::getName()->getCa())
            ->setNameIt(self::getName()->getIt());
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'iden' => self::getIden(),
            'nameEn' => self::getName()->getEn(),
            'nameEs' => self::getName()->getEs(),
            'nameCa' => self::getName()->getCa(),
            'nameIt' => self::getName()->getIt()
        ];
    }

    protected function setIden(string $iden): static
    {
        Assertion::maxLength($iden, 100, 'iden value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->iden = $iden;

        return $this;
    }

    public function getIden(): string
    {
        return $this->iden;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    protected function setName(Name $name): static
    {
        $isEqual = $this->name->equals($name);
        if ($isEqual) {
            return $this;
        }

        $this->name = $name;
        return $this;
    }
}
