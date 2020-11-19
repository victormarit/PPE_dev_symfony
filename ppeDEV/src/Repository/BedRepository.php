<?php

namespace App\Repository;

use App\Entity\Bed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bed[]    findAll()
 * @method Bed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bed::class);
    }

    // /**
    //  * @return Bed[] Returns an array of Bed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bed
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
