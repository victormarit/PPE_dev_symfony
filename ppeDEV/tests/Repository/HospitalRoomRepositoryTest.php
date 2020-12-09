<?php

namespace App\Tests\Repository;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HospitalRoomRepositoryTest extends KernelTestCase
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
            ->findOneBy(['number' => 'A101'])
        ;
        $this->assertSame('A101', $hospitalRoom->getNumber());

        $this->assertNotSame('A102', $hospitalRoom->getNumber());
    }

    public function testIdService()
    {
        /** @var $hospitalRoom HospitalRoom */
        $hospitalRoom = $this->entityManager
            ->getRepository(HospitalRoom::class)
            ->findOneBy(['number' => 'A101'])
        ;
        $this->assertSame($this->entityManager->getRepository(Service::class)->findOneBy(['name' => "Cardiologie"])->getId(), $hospitalRoom->getIdService()->getId());

        $this->assertNotSame($this->entityManager->getRepository(Service::class)->findOneBy(['name' => "Radiologie"])->getId(), $hospitalRoom->getIdService()->getId());
    }

    public function testGetBedsByNumber()
    {
        /** @var $hospitalRoom HospitalRoom */
        $hospitalRoom = $this->entityManager
            ->getRepository(HospitalRoom::class)
            ->findOneBy(['number' => 'A101'])
        ;
        $this->assertSame($this->entityManager->getRepository(Bed::class)->findBy(['number' => "1", "idHospitalRoom" => $hospitalRoom]), $hospitalRoom->getBeds()->toArray());

        $this->assertNotSame($this->entityManager->getRepository(Bed::class)->findBy(['number' => "2", "idHospitalRoom" => $hospitalRoom]), $hospitalRoom->getBeds()->toArray());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
