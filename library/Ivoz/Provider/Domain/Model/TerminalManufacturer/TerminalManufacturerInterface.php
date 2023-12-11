<?php

namespace Ivoz\Provider\Domain\Model\TerminalManufacturer;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* TerminalManufacturerInterface
*/
interface TerminalManufacturerInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): TerminalManufacturerDto;

    /**
     * @internal use EntityTools instead
     * @param null|TerminalManufacturerInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TerminalManufacturerDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TerminalManufacturerDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TerminalManufacturerDto;

    public function getIden(): string;

    public function getName(): string;

    public function getDescription(): string;
}
