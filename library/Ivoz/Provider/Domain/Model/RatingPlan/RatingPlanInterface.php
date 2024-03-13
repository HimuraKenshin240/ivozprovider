<?php

namespace Ivoz\Provider\Domain\Model\RatingPlan;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Cgr\Domain\Model\TpTiming\TpTimingInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\RatingPlanGroup\RatingPlanGroupInterface;
use Ivoz\Provider\Domain\Model\DestinationRateGroup\DestinationRateGroupInterface;
use Ivoz\Cgr\Domain\Model\TpRatingPlan\TpRatingPlanInterface;

/**
* RatingPlanInterface
*/
interface RatingPlanInterface extends LoggableEntityInterface
{
    public const TIMINGTYPE_ALWAYS = 'always';

    public const TIMINGTYPE_CUSTOM = 'custom';

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int;

    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array;

    /**
     * Transform Weekdays booleans to a string for TpTimings
     *
     * @return string
     */
    public function getWeekDays();

    /**
     * CGRates tag for this Rating Plan
     *
     * @return string
     */
    public function getCgrTag(): string;

    /**
     * CGrates tag for Timing associated to this Rating Plan
     *
     * @return string
     */
    public function getCgrTimingTag();

    public function setTpTiming(?TpTimingInterface $tpTiming = null): static;

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): RatingPlanDto;

    /**
     * @internal use EntityTools instead
     * @param null|RatingPlanInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?RatingPlanDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param RatingPlanDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): RatingPlanDto;

    public function getWeight(): float;

    public function getTimingType(): ?string;

    public function getTimeIn(): \DateTimeInterface;

    public function getMonday(): ?bool;

    public function getTuesday(): ?bool;

    public function getWednesday(): ?bool;

    public function getThursday(): ?bool;

    public function getFriday(): ?bool;

    public function getSaturday(): ?bool;

    public function getSunday(): ?bool;

    public function setRatingPlanGroup(RatingPlanGroupInterface $ratingPlanGroup): static;

    public function getRatingPlanGroup(): RatingPlanGroupInterface;

    public function getDestinationRateGroup(): DestinationRateGroupInterface;

    public function getTpTiming(): ?TpTimingInterface;

    public function setTpRatingPlan(TpRatingPlanInterface $tpRatingPlan): static;

    public function getTpRatingPlan(): ?TpRatingPlanInterface;
}
