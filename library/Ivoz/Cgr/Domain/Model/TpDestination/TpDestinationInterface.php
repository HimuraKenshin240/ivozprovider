<?php

namespace Ivoz\Cgr\Domain\Model\TpDestination;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Destination\DestinationInterface;

/**
* TpDestinationInterface
*/
interface TpDestinationInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): TpDestinationDto;

    /**
     * @internal use EntityTools instead
     * @param null|TpDestinationInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TpDestinationDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TpDestinationDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TpDestinationDto;

    public function getTpid(): string;

    public function getTag(): ?string;

    public function getPrefix(): string;

    public function getCreatedAt(): \DateTime;

    public function setDestination(DestinationInterface $destination): static;

    public function getDestination(): DestinationInterface;
}
