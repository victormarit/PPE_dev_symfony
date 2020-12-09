<?php

namespace App\DataFixtures;

use App\Entity\HospitalRoom;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HospitalRoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $hospitalRoom = new HospitalRoom();

        $hospitalRoom->setNumber("A101");
        $hospitalRoom->setIdService($manager->getRepository(Service::class)->findOneBy(['name' => "Cardiologie"]));

        $manager->persist($hospitalRoom);

        $hospitalRoom = new HospitalRoom();

        $hospitalRoom->setNumber("A102");
        $hospitalRoom->setIdService($manager->getRepository(Service::class)->findOneBy(['name' => "Radiologie"]));

        $manager->persist($hospitalRoom);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ServiceFixtures::class,
        );
    }
}
