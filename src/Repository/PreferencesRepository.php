<?php

namespace App\Repository;

use App\Entity\Preferences;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Preferences>
 */
class PreferencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Preferences::class);
    }

    public function findByUser(User $user): ?Preferences
{
    return $this->createQueryBuilder('p')
        ->where('p.user = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getOneOrNullResult();
}

}
