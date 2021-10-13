<?php

namespace Ivoz\Cgr\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Ivoz\Cgr\Domain\Model\TpCdr\TpCdr;
use Ivoz\Cgr\Domain\Model\TpCdr\TpCdrInterface;
use Ivoz\Cgr\Domain\Model\TpCdr\TpCdrRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Doctrine\Persistence\ManagerRegistry;

/**
 * TpCdrDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TpCdrDoctrineRepository extends ServiceEntityRepository implements TpCdrRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TpCdr::class);
    }

    /**
     * @inheritdoc
     * @see TpCdrRepository::getByOriginId
     */
    public function getByOriginId(string $originId)
    {
        return $this->findOneBy([
            'originId' => $originId
        ]);
    }

    /**
     * @param string $cgrid
     * @return TpCdrInterface | null
     */
    public function getDefaultRunByCgrid(string $cgrid)
    {
        $conditions = [
            ['cgrid', 'eq', $cgrid],
            ['runId', 'eq', '*default']
        ];

        $qb = $this
            ->createQueryBuilder('self')
            ->addCriteria(CriteriaHelper::fromArray($conditions));

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException) {
        }

        return null;
    }

    /**
     * @param string $cgrid
     * @return TpCdrInterface | null
     */
    public function getCarrierRunByCgrid(string $cgrid)
    {
        $conditions = [
            ['cgrid', 'eq', $cgrid],
            ['runId', 'eq', 'carrier'],
            ['requestType', 'eq', '*postpaid']
        ];

        $qb = $this
            ->createQueryBuilder('self')
            ->addCriteria(CriteriaHelper::fromArray($conditions));

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException) {
        }

        return null;
    }
}
