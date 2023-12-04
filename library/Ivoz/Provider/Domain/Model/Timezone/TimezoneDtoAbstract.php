<?php

namespace Ivoz\Provider\Domain\Model\Timezone;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Country\CountryDto;

/**
* TimezoneDtoAbstract
* @codeCoverageIgnore
*/
abstract class TimezoneDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $tz = null;

    /**
     * @var string|null
     */
    private $comment = '';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var string|null
     */
    private $labelEn = '';

    /**
     * @var string|null
     */
    private $labelEs = '';

    /**
     * @var string|null
     */
    private $labelCa = '';

    /**
     * @var string|null
     */
    private $labelIt = '';

    /**
     * @var CountryDto | null
     */
    private $country = null;

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
            'tz' => 'tz',
            'comment' => 'comment',
            'id' => 'id',
            'label' => [
                'en',
                'es',
                'ca',
                'it',
            ],
            'countryId' => 'country'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'tz' => $this->getTz(),
            'comment' => $this->getComment(),
            'id' => $this->getId(),
            'label' => [
                'en' => $this->getLabelEn(),
                'es' => $this->getLabelEs(),
                'ca' => $this->getLabelCa(),
                'it' => $this->getLabelIt(),
            ],
            'country' => $this->getCountry()
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

    public function setTz(string $tz): static
    {
        $this->tz = $tz;

        return $this;
    }

    public function getTz(): ?string
    {
        return $this->tz;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
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

    public function setLabelEn(string $labelEn): static
    {
        $this->labelEn = $labelEn;

        return $this;
    }

    public function getLabelEn(): ?string
    {
        return $this->labelEn;
    }

    public function setLabelEs(string $labelEs): static
    {
        $this->labelEs = $labelEs;

        return $this;
    }

    public function getLabelEs(): ?string
    {
        return $this->labelEs;
    }

    public function setLabelCa(string $labelCa): static
    {
        $this->labelCa = $labelCa;

        return $this;
    }

    public function getLabelCa(): ?string
    {
        return $this->labelCa;
    }

    public function setLabelIt(string $labelIt): static
    {
        $this->labelIt = $labelIt;

        return $this;
    }

    public function getLabelIt(): ?string
    {
        return $this->labelIt;
    }

    public function setCountry(?CountryDto $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?CountryDto
    {
        return $this->country;
    }

    public function setCountryId(?int $id): static
    {
        $value = !is_null($id)
            ? new CountryDto($id)
            : null;

        return $this->setCountry($value);
    }

    public function getCountryId(): ?int
    {
        if ($dto = $this->getCountry()) {
            return $dto->getId();
        }

        return null;
    }
}
