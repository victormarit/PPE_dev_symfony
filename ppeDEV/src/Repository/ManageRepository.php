<?php

namespace App\Repository;

use App\Entity\Manage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manage[]    findAll()
 * @method Manage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manage::class);
    }

    // /**
    //  * @return Manage[] Returns an array of Manage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manage
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function addLogerPatient($id_patient_id,	$id_staff_id, $modification, $action)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO manage('id_patient_id', 'id_staff_id', 'modification', 'action')
                values(:id_patient_id, :id_staff_id, :modification, :action) ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["id_patient_id" => $id_patient_id, "id_staff_id" => $id_staff_id, "modification" => $modification, "action" => $action]);
    }




    public function FindPatientLog(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT  manage.action, staff.last_name as ln, staff.first_name as fn, patient.first_name, patient.last_name, manage.modification
        From manage, staff, patient
        Where manage.id_staff_id = staff.id
        AND patient.id = manage.id_patient_id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function FindPatientLogQuery($query): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $query = "%".$query."%";
        $sql = '
        SELECT  manage.action, staff.last_name as ln, staff.first_name as fn, patient.first_name, patient.last_name, manage.modification
        From manage, staff, patient
        Where manage.id_staff_id = staff.id
        AND patient.id = manage.id_patient_id
        AND (patient.first_name like :name OR patient.last_name like :name)
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $query]);

        return $stmt->fetchAllAssociative();
    }
}
