<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    public function testAddNewGame(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@testaddnewgame.pl');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/game/new');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Add game');


    }
}
