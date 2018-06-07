<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\Ddi\DdiRepository;
use Ivoz\Provider\Domain\Model\Ddi\Ddi;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * DdiDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DdiDoctrineRepository extends ServiceEntityRepository implements DdiRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ddi::class);
    }
}
