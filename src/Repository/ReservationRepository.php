<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Retourne toutes les réservations d'un utilisateur (passager)
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.passager = :user')
            ->setParameter('user', $user)
            ->orderBy('r.dateReservation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne toutes les réservations pour un trajet
     */
    public function findByRoute(Route $route): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.route = :route')
            ->setParameter('route', $route)
            ->orderBy('r.dateReservation', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Vérifie si un utilisateur a déjà réservé ce trajet
     */
    public function userHasReservationForRoute(User $user, Route $route): bool
    {
        $result = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.passager = :user')
            ->andWhere('r.route = :route')
            ->setParameters([
                'user' => $user,
                'route' => $route,
            ])
            ->getQuery()
            ->getSingleScalarResult();

        return $result > 0;
    }
    public function findByDriver(User $driver): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.route', 'route')
            ->where('route.user = :driver')
            ->setParameter('driver', $driver)
            ->orderBy('r.dateReservation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
