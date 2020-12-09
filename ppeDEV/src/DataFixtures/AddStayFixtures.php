<?php

namespace App\DataFixtures;

use App\Entity\AddStay;
use App\Entity\Staff;
use App\Entity\Stay;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddStayFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $addStay = new AddStay();
        $addStay->setIdStaff($manager->getRepository(Staff::class)->findOneBy(['firstName' => 'Victor']));
        $addStay->setIdStay($manager->getRepository(Stay::class)->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00")]));
        $addStay->setModification(DateTime::createFromFormat('Y-m-d H:i:s', "2020-12-07 11:30:00"));

        $manager->persist($addStay);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            StayFixtures::class
        );
    }
}
