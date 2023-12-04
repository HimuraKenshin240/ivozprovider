<?php

namespace Ivoz\Provider\Domain\Model\Timezone;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Country\CountryInterface;

/**
* TimezoneInterface
*/
interface TimezoneInterface extends LoggableEntityInterface
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
    public static function createDto($id = null): TimezoneDto;

    /**
     * @internal use EntityTools instead
     * @param null|TimezoneInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TimezoneDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TimezoneDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TimezoneDto;

    public function getTz(): string;

    public function getComment(): ?string;

    public function getLabel(): Label;

    public function getCountry(): ?CountryInterface;
}
