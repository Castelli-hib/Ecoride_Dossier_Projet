<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findUnread(): array
{
    return $this->createQueryBuilder('c')
        ->where('c.isRead = false')
        ->orderBy('c.createdAt', 'DESC')
        ->getQuery()
        ->getResult();
}

public function findLatest(int $limit = 10): array
{
    return $this->createQueryBuilder('c')
        ->orderBy('c.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

}
