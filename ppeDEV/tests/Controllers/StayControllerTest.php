<?php

namespace App\tests;

use App\Entity\Patient;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StayControllerTest extends WebTestCase
{
    //tests fonctionnels route homepageStay
    public function testGetHomepageStayRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/user/séjour');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetHomepageStayRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/user/séjour');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetHomepageStayWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/user/séjour');
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route createPatientAndStay
    public function testcreatePatientAndStayRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/user/creationPatientEtSejour');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testcreatePatientAndStayRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/user/creationPatientEtSejour');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testcreatePatientAndStayWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/user/creationPatientEtSejour');
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route updateSaty
    public function testupdateSatyRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Stay')->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00") ]);
        $client->request('GET', '/user/modifierSéjour/'. $patient->getId() .'/{serviceId}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testupdateSatyRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Stay')->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00") ]);
        $client->request('GET', '/user/modifierSéjour/'. $patient->getId() .'/{serviceId}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testupdateSatyWithoutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Stay')->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00") ]);
        $client->request('GET', '/user/modifierSéjour/'. $patient->getId() .'/{serviceId}');
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route failUpdateStay
    public function testfailUpdateStayRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Stay')->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00") ]);
        $client->request('GET', '/user/erreurModifierSéjour/'. $patient->getId() .'/{serviceId}/1');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testfailUpdateStayRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Stay')->findOneBy(['creationDate' => DateTime::createFromFormat("Y-m-d H:i:s", "2020-12-07 10:00:00") ]);
        $client->request('GET', '/user/erreurModifierSéjour/'. $patient->getId() .'/{serviceId}/1');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testfailUpdateStayWithoutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/erreurModifierSéjour/'. $patient->getId() .'/{serviceId}/1');
        $this->assertResponseStatusCodeSame(302);
    }
}
