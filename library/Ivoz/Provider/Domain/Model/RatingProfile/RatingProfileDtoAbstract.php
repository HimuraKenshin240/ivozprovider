<?php

namespace Ivoz\Provider\Domain\Model\RatingProfile;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;
use Ivoz\Provider\Domain\Model\Carrier\CarrierDto;
use Ivoz\Provider\Domain\Model\RatingPlanGroup\RatingPlanGroupDto;
use Ivoz\Provider\Domain\Model\RoutingTag\RoutingTagDto;
use Ivoz\Cgr\Domain\Model\TpRatingProfile\TpRatingProfileDto;

/**
* RatingProfileDtoAbstract
* @codeCoverageIgnore
*/
abstract class RatingProfileDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $activationTime = 'CURRENT_TIMESTAMP';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var CompanyDto | null
     */
    private $company = null;

    /**
     * @var CarrierDto | null
     */
    private $carrier = null;

    /**
     * @var RatingPlanGroupDto | null
     */
    private $ratingPlanGroup = null;

    /**
     * @var RoutingTagDto | null
     */
    private $routingTag = null;

    /**
     * @var TpRatingProfileDto[] | null
     */
    private $tpRatingProfiles = null;

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
            'activationTime' => 'activationTime',
            'id' => 'id',
            'companyId' => 'company',
            'carrierId' => 'carrier',
            'ratingPlanGroupId' => 'ratingPlanGroup',
            'routingTagId' => 'routingTag'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'activationTime' => $this->getActivationTime(),
            'id' => $this->getId(),
            'company' => $this->getCompany(),
            'carrier' => $this->getCarrier(),
            'ratingPlanGroup' => $this->getRatingPlanGroup(),
            'routingTag' => $this->getRoutingTag(),
            'tpRatingProfiles' => $this->getTpRatingProfiles()
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

    public function setActivationTime(\DateTimeInterface|string $activationTime): static
    {
        $this->activationTime = $activationTime;

        return $this;
    }

    public function getActivationTime(): \DateTimeInterface|string|null
    {
        return $this->activationTime;
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

    public function setCompany(?CompanyDto $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?CompanyDto
    {
        return $this->company;
    }

    public function setCompanyId(?int $id): static
    {
        $value = !is_null($id)
            ? new CompanyDto($id)
            : null;

        return $this->setCompany($value);
    }

    public function getCompanyId(): ?int
    {
        if ($dto = $this->getCompany()) {
            return $dto->getId();
        }

        return null;
    }

    public function setCarrier(?CarrierDto $carrier): static
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getCarrier(): ?CarrierDto
    {
        return $this->carrier;
    }

    public function setCarrierId(?int $id): static
    {
        $value = !is_null($id)
            ? new CarrierDto($id)
            : null;

        return $this->setCarrier($value);
    }

    public function getCarrierId(): ?int
    {
        if ($dto = $this->getCarrier()) {
            return $dto->getId();
        }

        return null;
    }

    public function setRatingPlanGroup(?RatingPlanGroupDto $ratingPlanGroup): static
    {
        $this->ratingPlanGroup = $ratingPlanGroup;

        return $this;
    }

    public function getRatingPlanGroup(): ?RatingPlanGroupDto
    {
        return $this->ratingPlanGroup;
    }

    public function setRatingPlanGroupId(?int $id): static
    {
        $value = !is_null($id)
            ? new RatingPlanGroupDto($id)
            : null;

        return $this->setRatingPlanGroup($value);
    }

    public function getRatingPlanGroupId(): ?int
    {
        if ($dto = $this->getRatingPlanGroup()) {
            return $dto->getId();
        }

        return null;
    }

    public function setRoutingTag(?RoutingTagDto $routingTag): static
    {
        $this->routingTag = $routingTag;

        return $this;
    }

    public function getRoutingTag(): ?RoutingTagDto
    {
        return $this->routingTag;
    }

    public function setRoutingTagId(?int $id): static
    {
        $value = !is_null($id)
            ? new RoutingTagDto($id)
            : null;

        return $this->setRoutingTag($value);
    }

    public function getRoutingTagId(): ?int
    {
        if ($dto = $this->getRoutingTag()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param TpRatingProfileDto[] | null $tpRatingProfiles
     */
    public function setTpRatingProfiles(?array $tpRatingProfiles): static
    {
        $this->tpRatingProfiles = $tpRatingProfiles;

        return $this;
    }

    /**
    * @return TpRatingProfileDto[] | null
    */
    public function getTpRatingProfiles(): ?array
    {
        return $this->tpRatingProfiles;
    }
}
