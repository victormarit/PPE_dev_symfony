<?php

namespace App\Repository;

use App\Entity\Stay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stay|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stay|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stay[]    findAll()
 * @method Stay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stay::class);
    }

    // /**
    //  * @return Stay[] Returns an array of Stay objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stay
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function FindUserStays(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        Select service.name service, TIMEDIFF(stay.leave_date, stay.entry_date) duree, bed.number bed, hospital_room.number room, stay.entry_date entryDate, stay.leave_date leaveDate, stay.creation_date creationDate
        From stay, bed, hospital_room, service 
        Where id_Patient_id = :id and bed.id = stay.id_bed_id and bed.id_hospital_room_id = hospital_room.id and service.id = hospital_room.id_service_id
        ORDER BY service.id DESC;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAllAssociative();
    }
}
