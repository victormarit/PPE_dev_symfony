<?php

namespace App\Tests\Repository;

use App\Entity\HospitalRoom;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceRepositoryTest extends KernelTestCase
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

    public function testSearchByName()
    {
        /** @var  $service Service */
        $service = $this->entityManager
            ->getRepository(Service::class)
            ->findOneBy(['name' => 'Cardiologie'])
        ;
        $this->assertSame('Cardiologie', $service->getName());

        $this->assertNotSame('Radiologie', $service->getName());
    }

    public function testGetHospitalRoomsByName()
    {
        /** @var  $service Service */
        $service = $this->entityManager
            ->getRepository(Service::class)
            ->findOneBy(['name' => 'Radiologie'])
        ;
        $this->assertSame([$this->entityManager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A102'])], $service->getHospitalRooms()->toArray());

        $this->assertNotSame([$this->entityManager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A101'])], $service->getHospitalRooms()->toArray());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
