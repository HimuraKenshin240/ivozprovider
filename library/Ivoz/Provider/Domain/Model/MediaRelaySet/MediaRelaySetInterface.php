<?php

namespace Ivoz\Provider\Domain\Model\MediaRelaySet;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* MediaRelaySetInterface
*/
interface MediaRelaySetInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): MediaRelaySetDto;

    /**
     * @internal use EntityTools instead
     * @param null|MediaRelaySetInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?MediaRelaySetDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param MediaRelaySetDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): MediaRelaySetDto;

    public function getName(): string;

    public function getDescription(): ?string;
}
