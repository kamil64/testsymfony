<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class GameFixture extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $game = new Game();
            $game->setName('Game' . $i)
                ->setScore(substr($i, -1))
                ->setDescription('Game description' . $i)
                ->setRelaseDate(new \DateTime('-' . $i . ' days'));
            $manager->persist($game);
        }
        $manager->flush();
    }
}