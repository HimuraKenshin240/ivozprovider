<?php

namespace Ivoz\Kam\Domain\Model\UsersLocation;

use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* UsersLocationInterface
*/
interface UsersLocationInterface extends EntityInterface
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
    public static function createDto($id = null): UsersLocationDto;

    /**
     * @internal use EntityTools instead
     * @param null|UsersLocationInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?UsersLocationDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param UsersLocationDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): UsersLocationDto;

    public function getRuid(): string;

    public function getUsername(): string;

    public function getDomain(): ?string;

    public function getContact(): string;

    public function getReceived(): ?string;

    public function getPath(): ?string;

    public function getExpires(): \DateTime;

    public function getQ(): float;

    public function getCallid(): string;

    public function getCseq(): int;

    public function getLastModified(): \DateTime;

    public function getFlags(): int;

    public function getCflags(): int;

    public function getUserAgent(): string;

    public function getSocket(): ?string;

    public function getMethods(): ?int;

    public function getInstance(): ?string;

    public function getRegId(): int;

    public function getServerId(): int;

    public function getConnectionId(): int;

    public function getKeepalive(): int;

    public function getPartition(): int;
}
