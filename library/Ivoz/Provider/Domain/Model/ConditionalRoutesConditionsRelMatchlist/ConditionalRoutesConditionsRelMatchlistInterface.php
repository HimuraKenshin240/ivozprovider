<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelMatchlist;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface;
use Ivoz\Provider\Domain\Model\MatchList\MatchListInterface;

/**
* ConditionalRoutesConditionsRelMatchlistInterface
*/
interface ConditionalRoutesConditionsRelMatchlistInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array;

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int;

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): ConditionalRoutesConditionsRelMatchlistDto;

    /**
     * @internal use EntityTools instead
     * @param null|ConditionalRoutesConditionsRelMatchlistInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?ConditionalRoutesConditionsRelMatchlistDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ConditionalRoutesConditionsRelMatchlistDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): ConditionalRoutesConditionsRelMatchlistDto;

    public function setCondition(?ConditionalRoutesConditionInterface $condition = null): static;

    public function getCondition(): ?ConditionalRoutesConditionInterface;

    public function getMatchlist(): MatchListInterface;
}
