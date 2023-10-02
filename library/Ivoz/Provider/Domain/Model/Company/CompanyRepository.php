<?php

namespace Ivoz\Provider\Domain\Model\Company;

use Ivoz\Core\Domain\Service\Repository\RepositoryInterface;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;

/**
 * @extends RepositoryInterface<CompanyInterface, CompanyDto>
 */
interface CompanyRepository extends RepositoryInterface
{
    /**
     * @param int $id
     * @return array of ids
     */
    public function findIdsByBrandId($id);

    /**
     * Used by brand API access controls
     * @inheritdoc
     * @see \Ivoz\Provider\Domain\Model\Company\CompanyRepository::getSupervisedCompanyIdsByAdmin
     */
    public function getSupervisedCompanyIdsByAdmin(AdministratorInterface $admin);

    /**
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyInterface[]
     */
    public function getPrepaidCompanies();

    /**
     * @param int $brandId | null
     * @return string[]
     */
    public function getNames($brandId = null);

    /**
     * @return int[]
     */
    public function getVpbxIdsByBrand(int $brandId);

    /**
     * @return int[]
     */
    public function getResidentialIdsByBrand(int $brandId);

    /**
     * @return int[]
     */
    public function getRetailIdsByBrand(int $brandId);

    public function findOneByDomain(string $domainUsers): ?CompanyInterface;

    /**
     * @param int $brandId
     * @return int[]
     */
    public function getBillingEnabledCompanyIdsByBrand(int $brandId): array;

    /**
     * @return CompanyInterface[] | null
     */
    public function findByCorporationId(int $corporationId): ?array;

    /**
     * Used by brand API access controls
     * @return int[]
     */
    public function getCompanyIdsByAdminCorporation(AdministratorInterface $admin): array;

    /**
     * @param array<string, mixed> $criteria
     */
    public function count(array $criteria): int;

    public function countByBrand(int $brandId): int;

    /**
     * @return CompanyInterface[]
     */
    public function getLatestByBrandId(int $brandId, int $intemNum = 5): array;
}
