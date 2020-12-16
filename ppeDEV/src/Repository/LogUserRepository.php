<?php

namespace App\Repository;

use App\Entity\LogUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LogUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogUser[]    findAll()
 * @method LogUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogUser::class);
    }

    // /**
    //  * @return LogUser[] Returns an array of LogUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LogUser
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function FindUserLog(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * 
        From log_user, staff 
        Where log_user.staff_id = staff.id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function FindUserLogQuery($query): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $query = "%".$query."%";
        $sql = '
        SELECT * 
        From log_user, staff 
        Where log_user.staff_id = staff.id
        AND staff.login like :name
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $query]);

        return $stmt->fetchAllAssociative();
    }
}
