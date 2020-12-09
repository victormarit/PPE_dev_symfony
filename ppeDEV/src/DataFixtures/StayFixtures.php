<?php

namespace App\DataFixtures;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use App\Entity\Patient;
use App\Entity\Stay;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StayFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $stay = new Stay();
        $stay->setCreationDate(DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00"));
        $stay->setEntryDate(DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00"));
        $stay->setLeaveDate(DateTime::createFromFormat('Y-m-d H:i:s', "2020-12-08 12:00:00"));
        $stay->setIdPatient($manager->getRepository(Patient::class)->findOneBy(['firstName' => 'Jad']));
        $stay->setIdBed($manager->getRepository(Bed::class)->findOneBy(['number' => 1, 'idHospitalRoom' => $manager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A101'])]));

        $manager->persist($stay);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BedFixtures::class,
            PatientFixtures::class
        );
    }
}
