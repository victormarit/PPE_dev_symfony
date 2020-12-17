<?php

namespace App\DataFixtures;

use App\Entity\Manage;
use App\Entity\Patient;
use App\Entity\Staff;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ManageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manage = new Manage();
        $manage->setIdPatient($manager->getRepository(Patient::class)->findOneBy(['firstName' => 'Jad']));
        $manage->setIdStaff($manager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor']));
        $manage->setModification(DateTime::createFromFormat('Y-m-d H:i:s', "2020-12-07 11:00:00"));
        $manage->setAction("creation");

        $manager->persist($manage);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            StaffFixtures::class,
            PatientFixtures::class
        );
    }
}
