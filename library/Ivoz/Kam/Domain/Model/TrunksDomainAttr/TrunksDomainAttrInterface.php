<?php

namespace Ivoz\Kam\Domain\Model\TrunksDomainAttr;

use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;

/**
* TrunksDomainAttrInterface
*/
interface TrunksDomainAttrInterface extends EntityInterface
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
    public static function createDto($id = null): TrunksDomainAttrDto;

    /**
     * @internal use EntityTools instead
     * @param null|TrunksDomainAttrInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TrunksDomainAttrDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TrunksDomainAttrDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TrunksDomainAttrDto;

    public function getDid(): string;

    public function getName(): string;

    public function getType(): int;

    public function getValue(): string;

    public function getLastModified(): \DateTime;
}
