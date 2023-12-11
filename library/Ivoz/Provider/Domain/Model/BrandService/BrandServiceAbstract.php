<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\BrandService;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Service\ServiceInterface;
use Ivoz\Provider\Domain\Model\Brand\Brand;
use Ivoz\Provider\Domain\Model\Service\Service;

/**
* BrandServiceAbstract
* @codeCoverageIgnore
*/
abstract class BrandServiceAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var BrandInterface
     * inversedBy services
     */
    protected $brand;

    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * Constructor
     */
    protected function __construct(
        string $code
    ) {
        $this->setCode($code);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "BrandService",
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
    public static function createDto($id = null): BrandServiceDto
    {
        return new BrandServiceDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|BrandServiceInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?BrandServiceDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, BrandServiceInterface::class);

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
     * @param BrandServiceDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, BrandServiceDto::class);
        $code = $dto->getCode();
        Assertion::notNull($code, 'getCode value is null, but non null value was expected.');
        $brand = $dto->getBrand();
        Assertion::notNull($brand, 'getBrand value is null, but non null value was expected.');
        $service = $dto->getService();
        Assertion::notNull($service, 'getService value is null, but non null value was expected.');

        $self = new static(
            $code
        );

        $self
            ->setBrand($fkTransformer->transform($brand))
            ->setService($fkTransformer->transform($service));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param BrandServiceDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, BrandServiceDto::class);

        $code = $dto->getCode();
        Assertion::notNull($code, 'getCode value is null, but non null value was expected.');
        $brand = $dto->getBrand();
        Assertion::notNull($brand, 'getBrand value is null, but non null value was expected.');
        $service = $dto->getService();
        Assertion::notNull($service, 'getService value is null, but non null value was expected.');

        $this
            ->setCode($code)
            ->setBrand($fkTransformer->transform($brand))
            ->setService($fkTransformer->transform($service));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): BrandServiceDto
    {
        return self::createDto()
            ->setCode(self::getCode())
            ->setBrand(Brand::entityToDto(self::getBrand(), $depth))
            ->setService(Service::entityToDto(self::getService(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'code' => self::getCode(),
            'brandId' => self::getBrand()->getId(),
            'serviceId' => self::getService()->getId()
        ];
    }

    protected function setCode(string $code): static
    {
        Assertion::maxLength($code, 3, 'code value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->code = $code;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setBrand(BrandInterface $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }

    protected function setService(ServiceInterface $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getService(): ServiceInterface
    {
        return $this->service;
    }
}
