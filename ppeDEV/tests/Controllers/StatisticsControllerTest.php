<?php


namespace App\tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatisticsControllerTest extends WebTestCase
{
    public function testGetStatisticsPageRole_User(){
        $client = SecurityControllerTest::getUserClient();
        $client->request('GET', '/admin/statistics');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetStatisticsPageNotLoggedIn(){
        $client = static::createClient();
        $client->request('GET', '/admin/statistics');
        $this->assertResponseStatusCodeSame(302);
    }

    public function testGetStatisticsPageRole_Admin(){
        $client = SecurityControllerTest::getAdminClient();
        $client->request('GET', '/admin/statistics');
        $this->assertResponseStatusCodeSame(200);
    }
}
