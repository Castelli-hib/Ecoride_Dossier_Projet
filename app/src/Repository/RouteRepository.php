<?php

namespace App\Repository;

use App\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Route>
 */
class RouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    // src/Repository/RouteRepository.php
    public function findLatest(int $limit = 10): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.departureDay', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByTown(string $town, int $limit = 20): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.departureTown = :town OR r.arrivalTown = :town')
            ->setParameter('town', $town)
            ->orderBy('r.departureDay', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findWithUser(int $limit = 10)
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.user', 'u')
            ->addSelect('u')
            ->orderBy('r.departureDay', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
