<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $game->setName('LOL')
            ->setDescription('Opis LOL')
            ->setScore(8)
            ->setRelaseDate(new \DateTime('2018-12-12'));

        $entityManager->getRepository(Game::class)->save($game, true);

        return new Response('Zapisano gre ' . $game->getId());
//        return $this->render('game/index.html.twig', [
//            'controller_name' => 'GameController',
//        ]);
    }

    #[Route('/game/{id}', name: 'game.show')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }

    #[Route('/game/edit/{id}', name: 'game.edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $game = $entityManager->getRepository(Game::class)->find($id);
        if (!$game) {
            throw new \RuntimeException('incorrect id');
        }
        $game->setScore(1);

//        $entityManager->persist($game);
        $entityManager->flush();

        return $this->redirectToRoute('game.show', ['id' => $game->getId()]);

//        return $this->render('game/show.html.twig', [
//            'game' => $game
//        ]);
    }

    #[Route('/game/delete/{id}', name: 'game.delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $game = $entityManager->getRepository(Game::class)->find($id);
        if (!$game) {
            throw new \RuntimeException('incorrect id');
        }

//        $entityManager->persist($game);
        $entityManager->remove($game);
        $entityManager->flush();

        return $this->redirectToRoute('games');

//        return $this->render('game/show.html.twig', [
//            'game' => $game
//        ]);
    }

    #[Route('/games', name: 'games')]
    public function list(EntityManagerInterface $entityManager)
    {
        $games = $entityManager->getRepository(Game::class)->findAll();

        return $this->render('game/list.html.twig', [
            'games' => $games
        ]);
    }

    #[Route('/toplist', name: 'games.toplist')]
    public function topList(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAllGreaterThanScoreDql(4);

        return $this->render('game/toplist.html.twig', [
            'games' => $games
        ]);
    }
}
