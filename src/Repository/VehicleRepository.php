<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.user = :user')
            ->setParameter('user', $user)
            ->orderBy('v.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function searchByBrand(string $brand): array
    {
        return $this->createQueryBuilder('v')
            ->join('v.brand', 'b')
            ->where('b.name LIKE :brand')
            ->setParameter('brand', "%$brand%")
            ->getQuery()
            ->getResult();
    }
}
