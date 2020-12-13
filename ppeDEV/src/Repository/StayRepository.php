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

    public function FindPatientStays(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        Select stay.id as "stayId",service.id as "serviceId", service.name service, TIMEDIFF(stay.leave_date, stay.entry_date) duree, bed.number bed, hospital_room.number room, stay.entry_date entryDate, stay.leave_date leaveDate, stay.creation_date creationDate
        From stay, bed, hospital_room, service 
        Where id_Patient_id = :id and bed.id = stay.id_bed_id and bed.id_hospital_room_id = hospital_room.id and service.id = hospital_room.id_service_id
        GROUP BY stay.id
        ORDER BY service.id DESC;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAllAssociative();
    }

    public function findAllStays(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT service.id as "serviceId", stay.id,patient.first_name firstname, TIMEDIFF(stay.leave_date, stay.entry_date) duration, patient.last_name lastname, stay.entry_date entryDate, stay.leave_date leaveDate, stay.creation_date creationDate, bed.number bedNumber, hospital_room.number roomNumber, service.name serviceName
        from stay, patient, bed, hospital_room, service
        where stay.id_patient_id = patient.id
        and stay.id_bed_id = bed.id
        and bed.id_hospital_room_id = hospital_room.id
        and hospital_room.id_service_id = service.id
        GROUP BY stay.id
        ORDER BY stay.creation_date DESC
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function findStays($var): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $search = "%".$var."%";
        $sql = '
        SELECT service.id as "serviceId", stay.id, patient.first_name firstname, TIMEDIFF(stay.leave_date, stay.entry_date) duration, patient.last_name lastname, stay.entry_date entryDate, stay.leave_date leaveDate, stay.creation_date creationDate, bed.number bedNumber, hospital_room.number roomNumber, service.name serviceName
        from stay, patient, bed, hospital_room, service
        where stay.id_patient_id = patient.id
        and stay.id_bed_id = bed.id
        and (patient.last_name LIKE :val or patient.first_name LIKE :val)
        and bed.id_hospital_room_id = hospital_room.id
        and hospital_room.id_service_id = service.id
        GROUP BY stay.id
        ORDER BY stay.creation_date DESC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['val' => $search]);

        return $stmt->fetchAllAssociative();
    }

    public function AddStayPatient($bed, $id, $entry, $leave, $creation)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            INSERT INTO stay 
            (id_bed_id, id_patient_id, entry_date, leave_date, creation_date)
            VALUES
            (:bed, :idPatient, :entry, :leave, :creation)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["bed" => $bed, "idPatient" => $id, "entry" => $entry, "leave" => $leave, "creation" => $creation]);
    }

    public function nextAvailability($serviceId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
        SELECT stay.leave_date as 'leave'
        FROM stay, bed, hospital_room,service 
        WHERE stay.id_bed_id = bed.id 
        AND bed.id_hospital_room_id = hospital_room.id 
        AND service.id = hospital_room.id_service_id 
        AND service.id = :service 
        ORDER BY stay.leave_date DESC
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["service" => $serviceId]);

        return $stmt->fetchAllAssociative();
    }

    public function updateStayPatient($idStay, $entryDate, $leaveDate, $idBed)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
        UPDATE stay
        SET stay.id_bed_id = :bedId,
        	stay.entry_date = :date1,
            stay.leave_date = :date2
        WHERE stay.id = :stayId
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["bedId" => $idBed, "stayId" => $idStay, "date1" => $entryDate, "date2" => $leaveDate]);

    }
}
