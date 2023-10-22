<?php

namespace App\Service;

use Exception;

class RandomGamesGenerator
{
    /**
     * @throws Exception
     */
    public function get(): array
    {
        $games = [
            'The Witcher 3: Wild Hunt',
            'Doom Eternal',
            'Red Dead Redemption 2',
            'Cyberpunk 2077',
            'Assassin\'s Creed Valhalla',
            'Dark Souls III',
            'Sekiro: Shadows Die Twice',
            'Mass Effect: Legendary Edition',
            'Divinity: Original Sin 2',
            'Final Fantasy VII Remake'
        ];

        shuffle($games);

        return array_slice($games, 0, 5);
    }
}