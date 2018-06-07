<?php

namespace Ivoz\Kam\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Kam\Domain\Model\Trusted\TrustedRepository;
use Ivoz\Kam\Domain\Model\Trusted\Trusted;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * TrustedDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrustedDoctrineRepository extends ServiceEntityRepository implements TrustedRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trusted::class);
    }
}
