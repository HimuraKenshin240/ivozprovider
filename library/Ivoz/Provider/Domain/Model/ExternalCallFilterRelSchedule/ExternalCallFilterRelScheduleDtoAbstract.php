<?php

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterRelSchedule;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterDto;
use Ivoz\Provider\Domain\Model\Schedule\ScheduleDto;

/**
* ExternalCallFilterRelScheduleDtoAbstract
* @codeCoverageIgnore
*/
abstract class ExternalCallFilterRelScheduleDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var ExternalCallFilterDto | null
     */
    private $filter = null;

    /**
     * @var ScheduleDto | null
     */
    private $schedule = null;

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
            'id' => 'id',
            'filterId' => 'filter',
            'scheduleId' => 'schedule'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'id' => $this->getId(),
            'filter' => $this->getFilter(),
            'schedule' => $this->getSchedule()
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

    public function setFilter(?ExternalCallFilterDto $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?ExternalCallFilterDto
    {
        return $this->filter;
    }

    public function setFilterId(?int $id): static
    {
        $value = !is_null($id)
            ? new ExternalCallFilterDto($id)
            : null;

        return $this->setFilter($value);
    }

    public function getFilterId(): ?int
    {
        if ($dto = $this->getFilter()) {
            return $dto->getId();
        }

        return null;
    }

    public function setSchedule(?ScheduleDto $schedule): static
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getSchedule(): ?ScheduleDto
    {
        return $this->schedule;
    }

    public function setScheduleId(?int $id): static
    {
        $value = !is_null($id)
            ? new ScheduleDto($id)
            : null;

        return $this->setSchedule($value);
    }

    public function getScheduleId(): ?int
    {
        if ($dto = $this->getSchedule()) {
            return $dto->getId();
        }

        return null;
    }
}
