<?php

namespace App\tests;

use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaffControllerTest extends WebTestCase 
{
    //tests fonctionnels route homepageStaff
    public function testGetHomepageStaffRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/GestionPersonnel');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testGetHomepageStaffRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/GestionPersonnel');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetHomepageStaffWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/GestionPersonnel');
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route createNewStaffMember
    public function testGetCreateStaffRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/createStaffMember');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testGetCreateStaffRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/createStaffMember');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetCreateStaffWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/createStaffMember');
        $this->assertResponseStatusCodeSame(302);
    }

    //tests fonctionnels route updateNewStaffMember
    public function testGetUpdateStaffRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/modifierStaffMember/1');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testGetUpdateStaffRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/modifierStaffMember/1');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testGetUpdateStaffWithoutConnection(){
        $client = static::createClient();
        $client->request('GET', '/admin/modifierStaffMember/1');
        $this->assertResponseStatusCodeSame(302);
    }
} 