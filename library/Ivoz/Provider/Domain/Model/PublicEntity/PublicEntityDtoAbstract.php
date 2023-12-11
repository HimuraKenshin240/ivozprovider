<?php

namespace Ivoz\Provider\Domain\Model\PublicEntity;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;

/**
* PublicEntityDtoAbstract
* @codeCoverageIgnore
*/
abstract class PublicEntityDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $iden = null;

    /**
     * @var string|null
     */
    private $fqdn = null;

    /**
     * @var bool|null
     */
    private $platform = false;

    /**
     * @var bool|null
     */
    private $brand = false;

    /**
     * @var bool|null
     */
    private $client = false;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var string|null
     */
    private $nameEn = null;

    /**
     * @var string|null
     */
    private $nameEs = null;

    /**
     * @var string|null
     */
    private $nameCa = null;

    /**
     * @var string|null
     */
    private $nameIt = null;

    public function __construct(?int $id = null)
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
            'iden' => 'iden',
            'fqdn' => 'fqdn',
            'platform' => 'platform',
            'brand' => 'brand',
            'client' => 'client',
            'id' => 'id',
            'name' => [
                'en',
                'es',
                'ca',
                'it',
            ]
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'iden' => $this->getIden(),
            'fqdn' => $this->getFqdn(),
            'platform' => $this->getPlatform(),
            'brand' => $this->getBrand(),
            'client' => $this->getClient(),
            'id' => $this->getId(),
            'name' => [
                'en' => $this->getNameEn(),
                'es' => $this->getNameEs(),
                'ca' => $this->getNameCa(),
                'it' => $this->getNameIt(),
            ]
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

    public function setIden(string $iden): static
    {
        $this->iden = $iden;

        return $this;
    }

    public function getIden(): ?string
    {
        return $this->iden;
    }

    public function setFqdn(?string $fqdn): static
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    public function getFqdn(): ?string
    {
        return $this->fqdn;
    }

    public function setPlatform(bool $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    public function getPlatform(): ?bool
    {
        return $this->platform;
    }

    public function setBrand(bool $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): ?bool
    {
        return $this->brand;
    }

    public function setClient(bool $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getClient(): ?bool
    {
        return $this->client;
    }

    /**
     * @param int|null $id
     */
    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNameEn(?string $nameEn): static
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }

    public function setNameEs(?string $nameEs): static
    {
        $this->nameEs = $nameEs;

        return $this;
    }

    public function getNameEs(): ?string
    {
        return $this->nameEs;
    }

    public function setNameCa(?string $nameCa): static
    {
        $this->nameCa = $nameCa;

        return $this;
    }

    public function getNameCa(): ?string
    {
        return $this->nameCa;
    }

    public function setNameIt(?string $nameIt): static
    {
        $this->nameIt = $nameIt;

        return $this;
    }

    public function getNameIt(): ?string
    {
        return $this->nameIt;
    }
}
