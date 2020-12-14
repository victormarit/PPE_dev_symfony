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
}
