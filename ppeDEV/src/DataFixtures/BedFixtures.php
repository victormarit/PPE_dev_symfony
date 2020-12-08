<?php

namespace App\DataFixtures;

use App\Entity\Bed;
use App\Entity\HospitalRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BedFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $bed = new Bed();

        $bed->setNumber(1);
        $bed->setIdHospitalRoom($manager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A101']));

        $manager->persist($bed);

        $bed = new Bed();

        $bed->setNumber(1);
        $bed->setIdHospitalRoom($manager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A102']));

        $manager->persist($bed);

        $bed = new Bed();

        $bed->setNumber(2);
        $bed->setIdHospitalRoom($manager->getRepository(HospitalRoom::class)->findOneBy(['number' => 'A102']));

        $manager->persist($bed);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ServiceFixtures::class,
            HospitalRoomFixtures::class
        );
    }
}
