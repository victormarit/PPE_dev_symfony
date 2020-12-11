<?php

namespace App\tests;

use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnectionTests extends WebTestCase 
{

    private function getAdminClient(){
        $client = static::createClient();
        $userRepository = static::$container->get(StaffRepository::class);
        $testUser = $userRepository->findOneBy(["firstName" => 'Victor']);
        $client->loginUser($testUser);
        return $client;
    }
    private function getUserClient(){
        $client = static::createClient();
        $userRepository = static::$container->get(StaffRepository::class);
        $testUser = $userRepository->findOneBy(["firstName" => 'Grégoire']);
        $client->loginUser($testUser);
        return $client;
    }

    
    //Test fonctionnel Route /admin/GestionHopital
    public function testHomepageAdminWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testHomepageAdminAdminRole_Admin(){
        $client = $this->getAdminClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testHomepageAdminAdminRole_User(){
        $client = $this->getUserClient();
        $client->request('GET', '/admin/GestionHopital');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    
    //Test fonctionnel Route /user/homepagePatient
    public function testHomepagePatientUserWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testHomepagePatientRole_Admin(){
        $client = $this->getAdminClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testHomepagePatientRole_User(){
        $client = $this->getUserClient();
        $client->request('GET', '/user/homepagePatient');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
} 