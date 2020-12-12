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

    public function findBedsAndRooms($serviceId, $entryDate, $leaveDate): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
        SELECT bed.id bed
        FROM service, hospital_room, bed
        WHERE service.id = :idService
        AND service.id = hospital_room.id_service_id
        AND hospital_room.id = bed.id_hospital_room_id
        AND bed.id NOT IN ( 
            SELECT stay.id_bed_id FROM stay 
            WHERE stay.entry_date BETWEEN :entryDate AND :leaveDate
            OR stay.leave_date BETWEEN :entryDate AND :leaveDate)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["idService" => $serviceId, "entryDate" => $entryDate, "leaveDate" => $leaveDate]);

        return $stmt->fetchAllAssociative();
    }
}
