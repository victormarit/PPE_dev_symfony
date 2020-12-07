<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StaffFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $staff = new Staff();
        $staff->setFirstName("Victor");
        $staff->setLastName('Marit');
        $staff->setLogin("Victor.Marit");
        $staff->setPassword("$2y$10\$mBysVD3ACbCV6HyJQW/qSuC2IzgF34lsNsFXwC4keSvOGH.s1EKsK");

        $staff->setRoles(["ROLE_ADMIN"]);

        $staff2 = new Staff();
        $staff2->setFirstName("Grégoire");
        $staff2->setLastName('Hage');
        $staff2->setLogin("Grégoire.Hage");
        $staff2->setPassword("$2y$10\$mBysVD3ACbCV6HyJQW/qSuC2IzgF34lsNsFXwC4keSvOGH.s1EKsK");
        $staff2->setRoles([]);


        $manager->persist($staff);
        $manager->persist($staff2);
        $manager->flush();
    }
}
