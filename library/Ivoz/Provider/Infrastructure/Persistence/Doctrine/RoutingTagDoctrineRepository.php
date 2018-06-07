<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RoutingTag\RoutingTagRepository;
use Ivoz\Provider\Domain\Model\RoutingTag\RoutingTag;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * RoutingTagDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoutingTagDoctrineRepository extends ServiceEntityRepository implements RoutingTagRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoutingTag::class);
    }
}
