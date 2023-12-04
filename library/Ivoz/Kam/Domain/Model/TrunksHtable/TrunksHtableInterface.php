<?php

namespace Ivoz\Kam\Domain\Model\TrunksHtable;

use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* TrunksHtableInterface
*/
interface TrunksHtableInterface extends EntityInterface
{
    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int;

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): TrunksHtableDto;

    /**
     * @internal use EntityTools instead
     * @param null|TrunksHtableInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TrunksHtableDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TrunksHtableDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TrunksHtableDto;

    public function getKeyName(): string;

    public function getKeyType(): int;

    public function getValueType(): int;

    public function getKeyValue(): string;

    public function getExpires(): int;
}
