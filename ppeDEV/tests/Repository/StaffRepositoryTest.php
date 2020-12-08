<?php

namespace App\Tests\Repository;

use App\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StaffRepositoryTest extends KernelTestCase
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
        /** @var  $staff Staff */
        $staff = $this->entityManager
            ->getRepository(Staff::class)
            ->findOneBy(['firstName' => 'Victor'])
        ;
        $this->assertSame('Victor', $staff->getFirstName());

        $this->assertNotSame('Grégoire', $staff->getFirstName());
    }

    public function testPasswordHashing()
    {
        /** @var  $staff Staff */
        $staff = $this->entityManager
            ->getRepository(Staff::class)
            ->findOneBy(["firstName" => "Grégoire"]);

        $this->assertTrue(password_verify("adminadmin", $staff->getPassword()));

        $this->assertNotTrue(password_verify("useruser", $staff->getPassword()));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
