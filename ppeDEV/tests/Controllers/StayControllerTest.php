<?php

namespace App\tests;

use App\Repository\StaffRepository;
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

} 