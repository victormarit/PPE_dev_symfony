<?php

namespace App\tests;

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
        $client->request('GET', '/admin/modifierServiceHotpial/1');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testUpdateServiceHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/modifierServiceHotpial/1');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testUpdateServiceHospitalWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/modifierServiceHotpial/1');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route manageService
    public function testManageServiceHospitalRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/gestionService/1/{name}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testManageServiceHospitalRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/gestionService/1/{name}');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testManageServiceHospitalWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/gestionService/1/{name}');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route addRoom
    public function testaddRoomRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/ajouterChambre/1/{name}');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testaddRoomRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/ajouterChambre/1/{name}');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testaddRoomWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/ajouterChambre/1/{name}');
        $this->assertResponseStatusCodeSame(302);
    }

    //Test fonctionnel Route updateRoom
    public function testupdateRoomRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/1');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testupdateRoomRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/1');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testupdateRoomWithOutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/modifierChambre/{id}/{name}/1');
        $this->assertResponseStatusCodeSame(302);
    }
}