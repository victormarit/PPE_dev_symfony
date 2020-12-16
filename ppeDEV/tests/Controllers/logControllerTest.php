<?php

namespace App\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class logControllerTest extends WebTestCase
{
    //tests fonctionnels route logConnection
    public function testlogConnectionRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', "/admin/historiqueConnexion");
        $this->assertResponseStatusCodeSame(403);
    }
    public function testlogConnectionRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', "/admin/historiqueConnexion");
        $this->assertResponseStatusCodeSame(200);
    }
    public function testlogConnectionWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', "/admin/historiqueConnexion");
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route logManagePatient
    public function testlogManagePatientRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', "/admin/historiqueGestionPatient");
        $this->assertResponseStatusCodeSame(403);
    }
    public function testlogManagePatientRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', "/admin/historiqueGestionPatient");
        $this->assertResponseStatusCodeSame(200);
    }
    public function testlogManagePatientWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', "/admin/historiqueGestionPatient");
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route logManageStay
    public function testlogManageStayRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', "/admin/historiqueGestionSéjour");
        $this->assertResponseStatusCodeSame(403);
    }
    public function testlogManageStayRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', "/admin/historiqueGestionSéjour");
        $this->assertResponseStatusCodeSame(200);
    }
    public function testlogManageStayWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', "/admin/historiqueGestionSéjour");
        $this->assertResponseStatusCodeSame(302);
    }
}