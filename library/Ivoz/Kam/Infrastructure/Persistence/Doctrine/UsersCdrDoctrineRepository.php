<?php

namespace Ivoz\Kam\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Kam\Domain\Model\UsersCdr\UsersCdr;
use Ivoz\Kam\Domain\Model\UsersCdr\UsersCdrInterface;
use Ivoz\Kam\Domain\Model\UsersCdr\UsersCdrRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * UsersCdrDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsersCdrDoctrineRepository extends ServiceEntityRepository implements UsersCdrRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersCdr::class);
    }

    /**
     * @param int $userId
     * @return int
     */
    public function countByUserId($userId): int
    {
        $qb = $this->createQueryBuilder('self');

        return $qb
            ->select('count(self.id)')
            ->where($qb->expr()->eq('self.user', $userId))
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param string $callid
     * @return UsersCdrInterface[]
     */
    public function findByCallid($callid)
    {
        /** @var UsersCdrInterface[] $response */
        $response = $this->findBy([
            'callid' => $callid
        ]);

        return $response;
    }

    /**
     * @param string $callid
     * @return UsersCdrInterface | null
     */
    public function findOneByCallid($callid)
    {
        /** @var UsersCdrInterface $response */
        $response = $this->findOneBy([
            'callid' => $callid
        ]);

        return $response;
    }
}
