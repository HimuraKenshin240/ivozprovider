<?php

namespace Ivoz\Provider\Domain\Model\BrandService;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Brand\BrandDto;
use Ivoz\Provider\Domain\Model\Service\ServiceDto;

/**
* BrandServiceDtoAbstract
* @codeCoverageIgnore
*/
abstract class BrandServiceDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $code = null;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var BrandDto | null
     */
    private $brand = null;

    /**
     * @var ServiceDto | null
     */
    private $service = null;

    /**
     * @param string|int|null $id
     */
    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
    * @inheritdoc
    */
    public static function getPropertyMap(string $context = '', string $role = null): array
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'code' => 'code',
            'id' => 'id',
            'brandId' => 'brand',
            'serviceId' => 'service'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'code' => $this->getCode(),
            'id' => $this->getId(),
            'brand' => $this->getBrand(),
            'service' => $this->getService()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setBrand(?BrandDto $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): ?BrandDto
    {
        return $this->brand;
    }

    public function setBrandId($id): static
    {
        $value = !is_null($id)
            ? new BrandDto($id)
            : null;

        return $this->setBrand($value);
    }

    public function getBrandId(): ?int
    {
        if ($dto = $this->getBrand()) {
            return $dto->getId();
        }

        return null;
    }

    public function setService(?ServiceDto $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getService(): ?ServiceDto
    {
        return $this->service;
    }

    public function setServiceId($id): static
    {
        $value = !is_null($id)
            ? new ServiceDto($id)
            : null;

        return $this->setService($value);
    }

    public function getServiceId(): ?int
    {
        if ($dto = $this->getService()) {
            return $dto->getId();
        }

        return null;
    }
}
