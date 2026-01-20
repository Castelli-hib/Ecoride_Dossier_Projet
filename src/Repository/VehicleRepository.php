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

    /**
     * Retourne tous les véhicules d'un utilisateur
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.userVehicle = :user')  // nom exact du champ dans Vehicle
            ->setParameter('user', $user)
            ->orderBy('v.id', 'DESC') // tu peux remplacer v.id par v.year ou autre
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche des véhicules par marque
     */
    public function searchByBrand(string $brand): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.brandVehicle', 'b') // nom exact du champ
            ->addSelect('b')
            ->where('b.name LIKE :brand')
            ->setParameter('brand', "%$brand%")
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les véhicules actifs uniquement
     */
    public function findActiveVehicles(): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.isActif = :actif')
            ->setParameter('actif', true)
            ->orderBy('v.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
