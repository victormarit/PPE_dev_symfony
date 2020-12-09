<?php

namespace App\Tests\Repository;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BedRepositoryTest extends KernelTestCase
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

    public function testSearchByNumber()
    {
        /** @var $hospitalRoom HospitalRoom */
        $hospitalRoom = $this->entityManager
            ->getRepository(HospitalRoom::class)
            ->findOneBy(['number' => 'A101']);

        /** @var  $bed Bed */
        $bed = $this->entityManager
            ->getRepository(Bed::class)
            ->findOneBy(['number' => 1, 'idHospitalRoom' => $hospitalRoom])
        ;
        $this->assertSame(1, $bed->getNumber());

        $this->assertNotSame(2, $bed->getNumber());
    }

    public function testIdHospitalRoom()
    {
        /** @var $hospitalRoom HospitalRoom */
        $hospitalRoom = $this->entityManager
            ->getRepository(HospitalRoom::class)
            ->findOneBy(['number' => 'A101']);

        /** @var  $bed Bed */
        $bed = $this->entityManager
            ->getRepository(Bed::class)
            ->findOneBy(['number' => 1, 'idHospitalRoom' => $hospitalRoom])
        ;

        $this->assertSame($hospitalRoom->getId(), $bed->getIdHospitalRoom()->getId());

        $this->assertNotSame($this->entityManager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A102'])->getId(), $bed->getIdHospitalRoom()->getId());
    }

    //TODO: Test Stays with Bed number 1 from A101

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
