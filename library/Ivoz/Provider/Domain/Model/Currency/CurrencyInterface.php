<?php

namespace Ivoz\Provider\Domain\Model\Currency;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* CurrencyInterface
*/
interface CurrencyInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): CurrencyDto;

    /**
     * @internal use EntityTools instead
     * @param null|CurrencyInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?CurrencyDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param CurrencyDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): CurrencyDto;

    public function getIden(): string;

    public function getSymbol(): string;

    public function getName(): Name;
}
