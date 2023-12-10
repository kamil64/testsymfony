<?php

namespace App\Tests\Repository;

use App\Entity\Game;
use App\Repository\GameRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRepositoryTest extends KernelTestCase
{
    /**
     * @throws Exception
     */
    public function testSaveGame(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $entityManager = $container->get(EntityManagerInterface::class);

        $game = new Game();
        $game->setName('LOL')
            ->setDescription('Opis LOL')
            ->setScore(8)
            ->setRelaseDate(new DateTime('2018-12-12'));

        /**
         * @var GameRepository $repository
         */
        $repository = $entityManager->getRepository(Game::class);
        $repository->save($game, true);

        $this->assertIsInt($game->getId());
        $game = $repository->find($game->getId());

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals('LOL', $game->getName());
        $this->assertEquals('Opis LOL', $game->getDescription());
        $this->assertEquals(8, $game->getScore());
    }
}
