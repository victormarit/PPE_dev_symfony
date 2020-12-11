<?php

namespace App\Tests\Repository;

use App\Entity\AddStay;
use App\Entity\Manage;
use App\Entity\Patient;
use App\Entity\Staff;
use App\Entity\Stay;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddStayRepositoryTest extends KernelTestCase
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

    public function testSearchByIdStayIdStaff()
    {
        /** @var $addStay AddStay */
        $addStay = $this->entityManager
            ->getRepository(AddStay::class)
            ->findOneBy(['idStay' => $this->entityManager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]), 'idStaff' => $this->entityManager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor'])]);

        $this->assertEquals(DateTime::createFromFormat('Y-m-d H:i:s', "2020-12-07 11:30:00"), $addStay->getModification());
        $this->assertSame($this->entityManager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]), $addStay->getIdStay());
        $this->assertSame($this->entityManager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor']), $addStay->getIdStaff());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
