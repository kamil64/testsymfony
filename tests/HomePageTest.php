<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('O nas')->link();
        $client->click($link);

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h2', 'O pandzie');
    }
}
