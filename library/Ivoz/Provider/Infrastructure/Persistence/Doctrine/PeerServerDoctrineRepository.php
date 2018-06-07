<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\PeerServer\PeerServerRepository;
use Ivoz\Provider\Domain\Model\PeerServer\PeerServer;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * PeerServerDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PeerServerDoctrineRepository extends ServiceEntityRepository implements PeerServerRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PeerServer::class);
    }
}
