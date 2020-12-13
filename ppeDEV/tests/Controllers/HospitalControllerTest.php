<?php

namespace App\tests;

use App\Entity\HospitalRoom;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HospitalControllerTest extends WebTestCase
{
    //Test fonctionnel Route homepageHospital
    public function testhomepageHospitalRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testhomepageHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testhomepageHospitalWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route creerServiceHotpial
    public function testaddServiceHospitalRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/creerServiceHotpial');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testaddServiceHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/creerServiceHotpial');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testaddServiceHospitalWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/creerServiceHotpial');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route modifier un service
    public function testUpdateServiceHospitalRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/modifierServiceHotpial/' . $service->getId());
        $this->assertResponseStatusCodeSame(200);
    }
    public function testUpdateServiceHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/modifierServiceHotpial/' . $service->getId());
        $this->assertResponseStatusCodeSame(403);
    }
    public function testUpdateServiceHospitalWithOutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/modifierServiceHotpial/' . $service->getId());
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route manageService
    public function testManageServiceHospitalRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/gestionService/1/{name}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testManageServiceHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/gestionService/'. $service->getId() .'/{name}');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testManageServiceHospitalWithOutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/gestionService/'. $service->getId() .'/{name}');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route addRoom
    public function testaddRoomRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/ajouterChambre/'. $service->getId() .'/{name}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testaddRoomRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/ajouterChambre/'. $service->getId() .'/{name}');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testaddRoomWithOutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var Service $service */
        $service = $em->getRepository('App:Service')->findOneBy(['name' => 'Cardiologie']);
        $client->request('GET', '/admin/ajouterChambre/'. $service->getId() .'/{name}');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route updateRoom
    public function testupdateRoomRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var HospitalRoom $room */
        $room = $em->getRepository('App:HospitalRoom')->findOneBy(['number' => 'A101']);
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/'. $room->getId());
        $this->assertResponseStatusCodeSame(200);
    }
    public function testupdateRoomRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var HospitalRoom $room */
        $room = $em->getRepository('App:HospitalRoom')->findOneBy(['number' => 'A101']);
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/'. $room->getId());
        $this->assertResponseStatusCodeSame(403);
    }
    public function testupdateRoomWithOutConnection(){
        $client = static::createClient();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        /** @var HospitalRoom $room */
        $room = $em->getRepository('App:HospitalRoom')->findOneBy(['number' => 'A101']);
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/'. $room->getId());
        $this->assertResponseStatusCodeSame(302);
    }
}
