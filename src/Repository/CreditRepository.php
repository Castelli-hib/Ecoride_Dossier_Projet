<?php

namespace App\Repository;

use App\Entity\Credit;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    /**
     * Retourne le solde total d’un utilisateur
     */
    public function getBalanceForUser(User $user): float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('SUM(c.amount)')
            ->where('c.user = :user')
            ->setParameter('user', $user);

        return (float) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Retourne tous les crédits classés du plus récent au plus ancien
     */
    public function findLatestForUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $user)
            ->orderBy('c.updatedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
