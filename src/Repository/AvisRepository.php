<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avis>
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    public function findReceivedByUser(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.userRated = :user')
            ->setParameter('user', $user)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findGivenByUser(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.userRater = :user')
            ->setParameter('user', $user)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAverageRating(User $user): float
    {
        return (float) $this->createQueryBuilder('a')
            ->select('AVG(a.rating)')
            ->where('a.userRated = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function hasUserRated(User $rater, User $rated): bool
    {
        $count = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.userRater = :rater')
            ->andWhere('a.userRated = :rated')
            ->setParameters([
                'rater' => $rater,
                'rated' => $rated,
            ])
            ->getQuery()
            ->getSingleScalarResult();

        return $count > 0;
    }
}
