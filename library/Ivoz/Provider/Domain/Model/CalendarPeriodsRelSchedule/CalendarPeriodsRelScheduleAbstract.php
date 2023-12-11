<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\CalendarPeriodsRelSchedule;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\CalendarPeriod\CalendarPeriodInterface;
use Ivoz\Provider\Domain\Model\Schedule\ScheduleInterface;
use Ivoz\Provider\Domain\Model\CalendarPeriod\CalendarPeriod;
use Ivoz\Provider\Domain\Model\Schedule\Schedule;

/**
* CalendarPeriodsRelScheduleAbstract
* @codeCoverageIgnore
*/
abstract class CalendarPeriodsRelScheduleAbstract
{
    use ChangelogTrait;

    /**
     * @var ?CalendarPeriodInterface
     * inversedBy relSchedules
     */
    protected $calendarPeriod = null;

    /**
     * @var ScheduleInterface
     */
    protected $schedule;

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
            "CalendarPeriodsRelSchedule",
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
    public static function createDto($id = null): CalendarPeriodsRelScheduleDto
    {
        return new CalendarPeriodsRelScheduleDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|CalendarPeriodsRelScheduleInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?CalendarPeriodsRelScheduleDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, CalendarPeriodsRelScheduleInterface::class);

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
     * @param CalendarPeriodsRelScheduleDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, CalendarPeriodsRelScheduleDto::class);
        $schedule = $dto->getSchedule();
        Assertion::notNull($schedule, 'getSchedule value is null, but non null value was expected.');

        $self = new static();

        $self
            ->setCalendarPeriod($fkTransformer->transform($dto->getCalendarPeriod()))
            ->setSchedule($fkTransformer->transform($schedule));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param CalendarPeriodsRelScheduleDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, CalendarPeriodsRelScheduleDto::class);

        $schedule = $dto->getSchedule();
        Assertion::notNull($schedule, 'getSchedule value is null, but non null value was expected.');

        $this
            ->setCalendarPeriod($fkTransformer->transform($dto->getCalendarPeriod()))
            ->setSchedule($fkTransformer->transform($schedule));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): CalendarPeriodsRelScheduleDto
    {
        return self::createDto()
            ->setCalendarPeriod(CalendarPeriod::entityToDto(self::getCalendarPeriod(), $depth))
            ->setSchedule(Schedule::entityToDto(self::getSchedule(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'calendarPeriodId' => self::getCalendarPeriod()?->getId(),
            'scheduleId' => self::getSchedule()->getId()
        ];
    }

    public function setCalendarPeriod(?CalendarPeriodInterface $calendarPeriod = null): static
    {
        $this->calendarPeriod = $calendarPeriod;

        return $this;
    }

    public function getCalendarPeriod(): ?CalendarPeriodInterface
    {
        return $this->calendarPeriod;
    }

    protected function setSchedule(ScheduleInterface $schedule): static
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getSchedule(): ScheduleInterface
    {
        return $this->schedule;
    }
}
