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

    public function addLogerStay($id_stay_id, $id_staff_id, $modification, $act)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO add_stay(id_stay_id, id_staff_id, modification, action)
                VALUES(:id_stay_id, :id_staff_id, :modification, :act) ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["id_stay_id" => $id_stay_id, "id_staff_id" => $id_staff_id, "modification" => $modification, "act" => $act]);
    }

    public function FindStayLog(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT patient.first_name, patient.last_name, stay.entry_date, stay.leave_date, add_stay.modification, add_stay.action, staff.first_name as fn, staff.last_name as ln
        From add_stay, staff, stay, patient 
        Where add_stay.id_staff_id = staff.id
        AND stay.id = add_stay.id_stay_id 
        AND patient.id = stay.id_patient_id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function FindStayLogQuery($query): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $query = "%".$query."%";
        $sql = '
        SELECT patient.first_name, patient.last_name, stay.entry_date, stay.leave_date, add_stay.modification, add_stay.action, staff.first_name as fn, staff.last_name as ln
        From add_stay, staff, stay, patient 
        Where add_stay.id_staff_id = staff.id
        AND stay.id = add_stay.id_stay_id 
        AND patient.id = stay.id_patient_id
        AND (patient.first_name like :name OR patient.last_name like :name)
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $query]);

        return $stmt->fetchAllAssociative();
    }
}
