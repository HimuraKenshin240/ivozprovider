<?php

namespace Ivoz\Provider\Domain\Model\ProxyTrunk;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* ProxyTrunkInterface
*/
interface ProxyTrunkInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): ProxyTrunkDto;

    /**
     * @internal use EntityTools instead
     * @param null|ProxyTrunkInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?ProxyTrunkDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ProxyTrunkDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): ProxyTrunkDto;

    public function getName(): ?string;

    public function getIp(): string;

    public function getAdvertisedIp(): ?string;
}
