<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }


    public function search(array $filters=[])
    {
        $builder=$this->createQueryBuilder('a');
        $builder->orderBy('a.id','DESC');

              if(!empty($filters['pseudo']))
              {
                  $builder
                      ->leftJoin('a.userid', 'u')
                      ->andWhere('u.pseudo LIKE :pseudo')
                      ->setParameter('pseudo', '%' . $filters['pseudo'] . '%')
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

    }
   }
