<?php

namespace App\Tests\Repository;

use App\Entity\AddStay;
use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Patient;
use App\Entity\Staff;
use App\Entity\Stay;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StayRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByCreationDate()
    {
        /** @var $stays Stay */
        $stays = $this->entityManager
            ->getRepository(Stay::class)
            ->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]);

        $this->assertEquals(DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00"), $stays->getCreationDate());
    }

    public function testIdBed()
    {
        /** @var $stays Stay */
        $stays = $this->entityManager
            ->getRepository(Stay::class)
            ->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]);

        /** @var $hospitalRoom HospitalRoom */
        $hospitalRoom = $this->entityManager
            ->getRepository(HospitalRoom::class)
            ->findOneBy(['number' => 'A101']);

        /** @var  $bed Bed */
        $bed = $this->entityManager
            ->getRepository(Bed::class)
            ->findOneBy(['number' => 1, 'idHospitalRoom' => $hospitalRoom])
        ;

        $this->assertEquals($bed->getId(), $stays->getIdBed()->getId());
    }

    public function testIdPatient()
    {
        /** @var $stays Stay */
        $stays = $this->entityManager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]);

        /** @var $patient Patient */
        $patient = $this->entityManager->getRepository(Patient::class)->findOneBy(['firstName' => 'Jad']);


        $this->assertEquals($patient->getId(), $stays->getIdPatient()->getId());
    }

    public function testAddStay()
    {
        /** @var $stays Stay */
        $stays = $this->entityManager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]);

        /** @var $addStay AddStay */
        $addStay = $this->entityManager
            ->getRepository(AddStay::class)
            ->findOneBy(['idStay' => $this->entityManager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]), 'idStaff' => $this->entityManager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor'])]);

        $this->assertSame([$addStay], $stays->getAddStays()->toArray());

    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
