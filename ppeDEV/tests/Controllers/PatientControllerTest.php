<?php

namespace App\tests;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PatientControllerTest extends WebTestCase
{
    //Test fonctionnel Route /user/homePagePatient
    public function testGetHomepagePatientRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetHomepagePatientRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetHomepagePatientWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route /user/ajouterPatient
    public function testGetAddPatientRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/user/ajouterPatient');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetAddPatientRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/user/ajouterPatient');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetAddPatientWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/user/ajouterPatient');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route /user/modifierPatient
    public function testGetUpdatePatientRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/modifierPatient/' . $patient->getId());
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetUpdatePatientRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/modifierPatient/' . $patient->getId());
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetUpdatePatientWithoutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/modifierPatient/' . $patient->getId());
        $this->assertResponseStatusCodeSame(302);
    }


    //Test fonctionnel Route /user/séjoursPatient
    public function testSejourPatientRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/séjoursPatient/'. $patient->getId() .'/lastname/firstname');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testSejourPatientRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/séjoursPatient/'. $patient->getId() .'/lastname/firstname');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testSejourPatientWithoutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/séjoursPatient/'. $patient->getId() .'/lastname/firstname');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route /user/nouveauSéjour
    public function testNewStayRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/nouveauSéjour/'. $patient->getId() .'/{lastname}/{firstname}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testNewStayRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/nouveauSéjour/'. $patient->getId() .'/{lastname}/{firstname}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testNewStayWithoutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Patient $patient */
        $patient = $em->getRepository('App:Patient')->findOneBy(['firstName' => 'Jad']);
        $client->request('GET', '/user/nouveauSéjour/'. $patient->getId() .'/{lastname}/{firstname}');
        $this->assertResponseStatusCodeSame(302);
    }

}
