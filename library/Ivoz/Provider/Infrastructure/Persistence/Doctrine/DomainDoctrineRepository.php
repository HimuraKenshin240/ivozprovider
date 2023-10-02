<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandRepository;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;
use Ivoz\Provider\Domain\Model\Domain\Domain;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Model\Domain\DomainRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * DomainDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<Domain>
 */
class DomainDoctrineRepository extends ServiceEntityRepository implements DomainRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private BrandRepository $brandRepository,
        private CompanyRepository $companyRepository
    ) {
        parent::__construct($registry, Domain::class);
    }

    /**
     * @param string $domain
     * @return DomainInterface | null
     */
    public function findOneByDomain($domain)
    {
        /** @var DomainInterface $response */
        $response = $this->findOneBy([
            'domain' => $domain
        ]);

        return $response;
    }

    /**
     * Includes company domains
     * @param int $brandId
     * @return DomainInterface[]
     */
    public function findByBrandId(int $brandId): array
    {
        $domains = [];

        /** @var BrandInterface|null $brand */
        $brand = $this->brandRepository->find($brandId);
        if (!$brand) {
            return $domains;
        }

        $brandDomain = $brand->getDomain();
        if ($brandDomain) {
            $domains[] = $brandDomain;
        }

        $vpbxOnlyCriteria = CriteriaHelper::fromArray([
            ['type', 'eq', CompanyInterface::TYPE_VPBX]
        ]);
        $companies = $brand->getCompanies(
            $vpbxOnlyCriteria
        );

        foreach ($companies as $company) {
            $companyDomain = $this->findByCompanyId(
                $company->getId()
            );

            if (!$companyDomain) {
                continue;
            }
            $domains[] = $companyDomain;
        }

        return $domains;
    }

    /**
     * @param int $companyId
     * @return DomainInterface|null
     */
    public function findByCompanyId(int $companyId)
    {
        $company = $this->companyRepository->find($companyId);
        if (!$company) {
            return null;
        }

        return $company->getDomain();
    }
}
