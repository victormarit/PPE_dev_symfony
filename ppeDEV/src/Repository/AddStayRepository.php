<?php

namespace App\Repository;

use App\Entity\AddStay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddStay|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddStay|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddStay[]    findAll()
 * @method AddStay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddStayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddStay::class);
    }

    // /**
    //  * @return AddStay[] Returns an array of AddStay objects
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
    public function findOneBySomeField($value): ?AddStay
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
