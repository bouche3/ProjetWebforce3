<?php

namespace App\Repository;

use App\Entity\MixteTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MixteTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method MixteTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method MixteTemplate[]    findAll()
 * @method MixteTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MixteTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MixteTemplate::class);
    }

    // /**
    //  * @return MixteTemplate[] Returns an array of MixteTemplate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MixteTemplate
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
