<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $patient = new Patient();
        $patient->setFirstName("Jad");
        $patient->setLastName("Daouk");
        $patient->setBirthDate(DateTime::createFromFormat('Y-m-d', "2001-02-19"));
        $patient->setBloodType("B");
        $patient->setSocialSecurityNumber("123456");

        $manager->persist($patient);

        $manager->flush();
    }
}
