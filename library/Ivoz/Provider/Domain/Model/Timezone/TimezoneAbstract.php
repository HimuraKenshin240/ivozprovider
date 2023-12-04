<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\Timezone;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Timezone\Label;
use Ivoz\Provider\Domain\Model\Country\CountryInterface;
use Ivoz\Provider\Domain\Model\Country\Country;

/**
* TimezoneAbstract
* @codeCoverageIgnore
*/
abstract class TimezoneAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $tz;

    /**
     * @var ?string
     */
    protected $comment = '';

    /**
     * @var Label
     */
    protected $label;

    /**
     * @var ?CountryInterface
     */
    protected $country = null;

    /**
     * Constructor
     */
    protected function __construct(
        string $tz,
        Label $label
    ) {
        $this->setTz($tz);
        $this->label = $label;
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "Timezone",
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
    public static function createDto($id = null): TimezoneDto
    {
        return new TimezoneDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|TimezoneInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TimezoneDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, TimezoneInterface::class);

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
     * @param TimezoneDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, TimezoneDto::class);
        $labelEn = $dto->getLabelEn();
        Assertion::notNull($labelEn, 'labelEn value is null, but non null value was expected.');
        $labelEs = $dto->getLabelEs();
        Assertion::notNull($labelEs, 'labelEs value is null, but non null value was expected.');
        $labelCa = $dto->getLabelCa();
        Assertion::notNull($labelCa, 'labelCa value is null, but non null value was expected.');
        $labelIt = $dto->getLabelIt();
        Assertion::notNull($labelIt, 'labelIt value is null, but non null value was expected.');
        $tz = $dto->getTz();
        Assertion::notNull($tz, 'getTz value is null, but non null value was expected.');

        $label = new Label(
            $labelEn,
            $labelEs,
            $labelCa,
            $labelIt
        );

        $self = new static(
            $tz,
            $label
        );

        $self
            ->setComment($dto->getComment())
            ->setCountry($fkTransformer->transform($dto->getCountry()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param TimezoneDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, TimezoneDto::class);

        $labelEn = $dto->getLabelEn();
        Assertion::notNull($labelEn, 'labelEn value is null, but non null value was expected.');
        $labelEs = $dto->getLabelEs();
        Assertion::notNull($labelEs, 'labelEs value is null, but non null value was expected.');
        $labelCa = $dto->getLabelCa();
        Assertion::notNull($labelCa, 'labelCa value is null, but non null value was expected.');
        $labelIt = $dto->getLabelIt();
        Assertion::notNull($labelIt, 'labelIt value is null, but non null value was expected.');
        $tz = $dto->getTz();
        Assertion::notNull($tz, 'getTz value is null, but non null value was expected.');

        $label = new Label(
            $labelEn,
            $labelEs,
            $labelCa,
            $labelIt
        );

        $this
            ->setTz($tz)
            ->setComment($dto->getComment())
            ->setLabel($label)
            ->setCountry($fkTransformer->transform($dto->getCountry()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TimezoneDto
    {
        return self::createDto()
            ->setTz(self::getTz())
            ->setComment(self::getComment())
            ->setLabelEn(self::getLabel()->getEn())
            ->setLabelEs(self::getLabel()->getEs())
            ->setLabelCa(self::getLabel()->getCa())
            ->setLabelIt(self::getLabel()->getIt())
            ->setCountry(Country::entityToDto(self::getCountry(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'tz' => self::getTz(),
            'comment' => self::getComment(),
            'labelEn' => self::getLabel()->getEn(),
            'labelEs' => self::getLabel()->getEs(),
            'labelCa' => self::getLabel()->getCa(),
            'labelIt' => self::getLabel()->getIt(),
            'countryId' => self::getCountry()?->getId()
        ];
    }

    protected function setTz(string $tz): static
    {
        Assertion::maxLength($tz, 255, 'tz value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->tz = $tz;

        return $this;
    }

    public function getTz(): string
    {
        return $this->tz;
    }

    protected function setComment(?string $comment = null): static
    {
        if (!is_null($comment)) {
            Assertion::maxLength($comment, 150, 'comment value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->comment = $comment;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    protected function setLabel(Label $label): static
    {
        $isEqual = $this->label->equals($label);
        if ($isEqual) {
            return $this;
        }

        $this->label = $label;
        return $this;
    }

    protected function setCountry(?CountryInterface $country = null): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?CountryInterface
    {
        return $this->country;
    }
}
