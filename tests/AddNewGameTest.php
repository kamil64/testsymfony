<?php

namespace App\Tests;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    /**
     * @throws Exception
     */
    public function testAddNewGame(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = static::getContainer()->get(UserRepository::class);
        /**
         * @var CategoryRepository $categoryRepository
         */
        $categoryRepository = static::getContainer()->get(CategoryRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@testaddnewgame.pl');
        $testCategory = $categoryRepository->findAll()[0];

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/game/new');

        $form = $crawler->selectButton('Save')->form();
        $form['game[name]'] = 'Test Game';
        $form['game[description]'] = 'Test Game Description';
        $form['game[score]'] = '5';
        $form['game[relaseDate]'] = '2023-01-01';
        $form['game[agreeTerms]']->tick();
        $form['game[category]']->select($testCategory->getId());

        $client->submit($form);

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('.alert-success', 'Zapisano grę.');
        self::assertSelectorTextContains('.game-name', 'Nazwa: Test Game');
    }
}
