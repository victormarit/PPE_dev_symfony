<?php

namespace App\Tests\Repository;

use App\Entity\Manage;
use App\Entity\Patient;
use App\Entity\Staff;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManageRepositoryTest extends KernelTestCase
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

    public function testSearchByIdPatientIdStaff()
    {
        /** @var $manage Manage */
        $manage = $this->entityManager
            ->getRepository(Manage::class)
            ->findOneBy(['idPatient' => $this->entityManager->getRepository(Patient::class)->findOneBy(['firstName' => 'Jad']), 'idStaff' => $this->entityManager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor'])]);

        $this->assertEquals(DateTime::createFromFormat('Y-m-d H:i:s', "2020-12-07 11:00:00"), $manage->getModification());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
