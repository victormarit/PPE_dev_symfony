<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    // /**
    //  * @return Service[] Returns an array of Service objects
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
    public function findOneBySomeField($value): ?Service
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function FindServices(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        Select service.id, service.name, Count(DISTINCT bed.id) bed 
        From service 
        LEFT JOIN hospital_room ON service.id = hospital_room.id_service_id
        LEFT JOIN bed ON hospital_room.id = bed.id_hospital_room_id
        GROUP BY service.id
        ORDER BY service.name
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function FindServicesQuery($query): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $search = "%".$query."%";
        $sql = '
        Select service.id, service.name, Count(DISTINCT bed.id) bed 
        From service 
        LEFT JOIN hospital_room ON service.id = hospital_room.id_service_id
        LEFT JOIN bed ON hospital_room.id = bed.id_hospital_room_id
        WHERE service.name LIKE :query
        GROUP BY service.id
        ORDER BY service.name
        ';;
        $stmt = $conn->prepare($sql);
        $stmt->execute(['query' => $search]);

        return $stmt->fetchAllAssociative();
    }
}