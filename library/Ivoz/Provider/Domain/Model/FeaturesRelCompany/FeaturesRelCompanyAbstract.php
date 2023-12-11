<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\FeaturesRelCompany;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Feature\FeatureInterface;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\Feature\Feature;

/**
* FeaturesRelCompanyAbstract
* @codeCoverageIgnore
*/
abstract class FeaturesRelCompanyAbstract
{
    use ChangelogTrait;

    /**
     * @var ?CompanyInterface
     * inversedBy relFeatures
     */
    protected $company = null;

    /**
     * @var FeatureInterface
     */
    protected $feature;

    /**
     * Constructor
     */
    protected function __construct()
    {
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "FeaturesRelCompany",
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
    public static function createDto($id = null): FeaturesRelCompanyDto
    {
        return new FeaturesRelCompanyDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|FeaturesRelCompanyInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?FeaturesRelCompanyDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, FeaturesRelCompanyInterface::class);

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
     * @param FeaturesRelCompanyDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, FeaturesRelCompanyDto::class);
        $feature = $dto->getFeature();
        Assertion::notNull($feature, 'getFeature value is null, but non null value was expected.');

        $self = new static();

        $self
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setFeature($fkTransformer->transform($feature));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param FeaturesRelCompanyDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, FeaturesRelCompanyDto::class);

        $feature = $dto->getFeature();
        Assertion::notNull($feature, 'getFeature value is null, but non null value was expected.');

        $this
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setFeature($fkTransformer->transform($feature));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): FeaturesRelCompanyDto
    {
        return self::createDto()
            ->setCompany(Company::entityToDto(self::getCompany(), $depth))
            ->setFeature(Feature::entityToDto(self::getFeature(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'companyId' => self::getCompany()?->getId(),
            'featureId' => self::getFeature()->getId()
        ];
    }

    public function setCompany(?CompanyInterface $company = null): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?CompanyInterface
    {
        return $this->company;
    }

    protected function setFeature(FeatureInterface $feature): static
    {
        $this->feature = $feature;

        return $this;
    }

    public function getFeature(): FeatureInterface
    {
        return $this->feature;
    }
}
