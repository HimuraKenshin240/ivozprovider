<?php

namespace Ivoz\Provider\Domain\Model\BannedAddress;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;

/**
* BannedAddressInterface
*/
interface BannedAddressInterface extends LoggableEntityInterface
{
    public const BLOCKER_ANTIFLOOD = 'antiflood';

    public const BLOCKER_IPFILTER = 'ipfilter';

    public const BLOCKER_ANTIBRUTEFORCE = 'antibruteforce';

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
    public static function createDto($id = null): BannedAddressDto;

    /**
     * @internal use EntityTools instead
     * @param null|BannedAddressInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?BannedAddressDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param BannedAddressDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): BannedAddressDto;

    public function getIp(): ?string;

    public function getBlocker(): ?string;

    public function getAor(): ?string;

    public function getDescription(): ?string;

    public function getLastTimeBanned(): ?\DateTime;

    public function getBrand(): ?BrandInterface;

    public function getCompany(): ?CompanyInterface;
}
