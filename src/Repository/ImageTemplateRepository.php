<?php

namespace App\Repository;

use App\Entity\ImageTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageTemplate[]    findAll()
 * @method ImageTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageTemplate::class);
    }

    // /**
    //  * @return ImageTemplate[] Returns an array of ImageTemplate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageTemplate
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
