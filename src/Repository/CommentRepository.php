<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function topArticle()
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('articleid_id', 'article');
        $rsm->addScalarResult('topArticle', 'topArticle');
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createNativeQuery('SELECT articleid_id, COUNT(*) AS topArticle FROM `comment` GROUP BY articleid_id ORDER BY topArticle DESC LIMIT 1', $rsm);
        return $query->getOneOrNullResult();
    }

    /**
     * @param array $filters
     * @return Comment[]
     */

    public function search(array $filters = [])
    {
        $builder = $this->createQueryBuilder('c');
        $builder->orderBy('c.id', 'DESC');

        if (!empty($filters['pseudo'])) {
            $builder
                ->leftJoin('c.userid', 'u')
                ->andWhere('u.pseudo LIKE :pseudo')
                ->setParameter('pseudo', '%' . $filters['pseudo'] . '%');
        }
        if (!empty($filters['start_date'])) {
            $builder
                ->andWhere('c.date >= :start_date')
                ->setParameter('start_date', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $builder
                ->andWhere('c.date <= :end_date')
                ->setParameter('end_date', $filters['end_date']);
        }

        $query=$builder->getQuery();
        return $query->getResult();


    }
}
