<?php

namespace App\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase; // permet de tester les controller et de voir les réponses
use Symfony\Component\BrowserKit\Response;

class AppTests extends TestCase 
{
    public function testAreWorking(){
        $this->assertEquals(2, 1+1);
    }
} 

class ConnectionTests extends WebTestCase 
{
    public function testGetConnectionPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
} 