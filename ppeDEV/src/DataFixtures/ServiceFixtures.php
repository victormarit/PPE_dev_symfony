<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $service = new Service();
        $service->setName("Cardiologie");

        $manager->persist($service);

        $service = new Service();
        $service->setName("Radiologie");

        $manager->persist($service);

        $manager->flush();
    }
}
