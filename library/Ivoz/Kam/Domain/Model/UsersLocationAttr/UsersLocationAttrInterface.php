<?php

namespace Ivoz\Kam\Domain\Model\UsersLocationAttr;

use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* UsersLocationAttrInterface
*/
interface UsersLocationAttrInterface extends EntityInterface
{
    /**
     * Get id
     * @codeCoverageIgnore
     */
    public function getId(): ?string;

    /**
     * @param string | null $id
     */
    public static function createDto($id = null): UsersLocationAttrDto;

    /**
     * @internal use EntityTools instead
     * @param null|UsersLocationAttrInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?UsersLocationAttrDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param UsersLocationAttrDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): UsersLocationAttrDto;

    public function getRuid(): string;

    public function getUsername(): string;

    public function getDomain(): ?string;

    public function getAname(): string;

    public function getAtype(): int;

    public function getAvalue(): string;

    public function getLastModified(): \DateTime;
}
