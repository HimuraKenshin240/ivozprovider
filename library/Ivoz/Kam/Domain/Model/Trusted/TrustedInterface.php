<?php

namespace Ivoz\Kam\Domain\Model\Trusted;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;

/**
* TrustedInterface
*/
interface TrustedInterface extends LoggableEntityInterface
{
    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int;

    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array;

    public function setSrcIp(?string $srcIp = null): static;

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): TrustedDto;

    /**
     * @internal use EntityTools instead
     * @param null|TrustedInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?TrustedDto;

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TrustedDto $dto
     */
    public static function fromDto(DataTransferObjectInterface $dto, ForeignKeyTransformerInterface $fkTransformer): static;

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): TrustedDto;

    public function getSrcIp(): ?string;

    public function getProto(): ?string;

    public function getFromPattern(): ?string;

    public function getRuriPattern(): ?string;

    public function getTag(): ?string;

    public function getDescription(): ?string;

    public function getPriority(): int;

    public function getCompany(): CompanyInterface;
}
