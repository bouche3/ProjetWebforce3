<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function search(array $filters = [])
    {

        $builder = $this->createQueryBuilder('a');

        $builder->orderBy('a.date', 'DESC');

        if(!empty($filters['categoryid'])){
            $builder
                ->andWhere('a.categoryid = :category')
                ->setParameter('category', $filters['categoryid'])
            ;
        }

        if(!empty($filters['continent'])){
            $builder
                ->leftJoin('a.countryid', 'c')
                ->andWhere('c.continentName = :continent')
                ->setParameter('continent', $filters['continent'])
            ;
        }

        if(!empty($filters['country'])){
            $builder
                ->andWhere('a.countryid = :country')
                ->setParameter('country', $filters['country'])
            ;
        }

        if(!empty($filters['start_date'])){
            $builder
                ->andWhere('a.date >= :start_date')
                ->setParameter('start_date', $filters['start_date'])
            ;
        }

        if(!empty($filters['end_date'])){
            $builder
                ->andWhere('a.date <= :end_date')
                ->setParameter('end_date', $filters['end_date'])
            ;
        }

        if(!empty($filters['pseudo'])){
            $builder
                ->leftJoin('a.userid', 'u')
                ->andWhere('u.pseudo LIKE :pseudo')
                ->setParameter('pseudo', '%' . $filters['pseudo'] . '%')
            ;
        }

        if(!empty($filters['keyword'])){
            $builder
                ->leftJoin('a.templateImageid', 'ti')
                ->leftJoin('a.templateMixedid', 'tm')
                ->leftJoin('a.templateTextid', 'tt')
                ->andWhere('a.title LIKE :keyword')
                ->orWhere('ti.introduction LIKE :keyword')
                ->orWhere('ti.conclusion LIKE :keyword')
                ->orWhere('tm.introduction LIKE :keyword')
                ->orWhere('tm.conclusion LIKE :keyword')
                ->orWhere('tm.content1 LIKE :keyword')
                ->orWhere('tm.content2 LIKE :keyword')
                ->orWhere('tt.introduction LIKE :keyword')
                ->orWhere('tt.conclusion LIKE :keyword')
                ->orWhere('tt.content1 LIKE :keyword')
                ->orWhere('tt.content2 LIKE :keyword')
                ->setParameter('keyword', '%' . $filters['keyword'] . '%')
            ;
        }

        $query = $builder->getQuery();

        return $query->getResult();

    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
