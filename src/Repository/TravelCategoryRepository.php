<?php

namespace App\Repository;

use App\Entity\TravelCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TravelCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TravelCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TravelCategory[]    findAll()
 * @method TravelCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravelCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TravelCategory::class);
    }

    // /**
    //  * @return TravelCategory[] Returns an array of TravelCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TravelCategory
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
