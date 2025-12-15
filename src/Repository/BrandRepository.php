<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brand>
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function searchByName(string $term): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.name LIKE :term')
            ->setParameter('term', "%$term%")
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
