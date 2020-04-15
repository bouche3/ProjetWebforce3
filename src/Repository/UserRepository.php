<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param array $filters
     * @return User[]
     */
    public function search(array $filters=[])
    {
        //constructeur de requete sql
        //"a" est l'alias de l'entité Article
        $builder=$this->createQueryBuilder('a');
        //tri par date
        $builder->orderBy('a.registrationDate','DESC');
        if(!empty($filters['pseudo']))
        {
            $builder
                //ajoute un élement à la clause WHERE
            ->andWhere('a.pseudo LIKE :pseudo')
             ->setParameter('pseudo','%'.$filters['pseudo'].'%');
        }
        if(!empty($filters['email']))
        {
            $builder
                ->andWhere('a.email =:email')
                ->setParameter('email',$filters['email']);
        }
        if(!empty($filters['start_date']))
        {
            $builder
                ->andWhere('a.registrationDate >= :start_date')
                ->setParameter('start_date',$filters['start_date']);
        }
        if(!empty($filters['end_date']))
        {
            $builder
                ->andWhere('a.registrationDate <= :end_date')
                ->setParameter('end_date',$filters['end_date']);
        }
    //object Query generated
        $query=$builder->getQuery();
        //return an array of objects members/users
        return $query->getResult();


    }
}
