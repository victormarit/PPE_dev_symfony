<?php

namespace App\Tests\Repository;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Patient;
use App\Entity\Stay;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepositoryTest extends KernelTestCase
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

    public function testSearchByFirstName()
    {
        /** @var $patient Patient */
        $patient = $this->entityManager
            ->getRepository(Patient::class)
            ->findOneBy(['firstName' => 'Jad']);

        $this->assertEquals('Jad', $patient->getFirstName());
    }

    public function testSearchByLastName()
    {
        /** @var $patient Patient */
        $patient = $this->entityManager
            ->getRepository(Patient::class)
            ->findOneBy(['firstName' => 'Jad']);

        $this->assertEquals('Daouk', $patient->getLastName());
    }

    public function testSearchBySocialSecurityNumber()
    {
        /** @var $patient Patient */
        $patient = $this->entityManager
            ->getRepository(Patient::class)
            ->findOneBy(['firstName' => 'Jad']);

        $this->assertEquals('123456', $patient->getSocialSecurityNumber());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
