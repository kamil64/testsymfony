<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/new', name: 'app_game_new')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(GameType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Game $game
             */
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Zapisano grę.');

            return $this->redirectToRoute('game.show', ['id' => $game->getId()]); // TOOO
        }

        return $this->render('game/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/game/{id}', name: 'game.show')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }

    #[Route('/game/edit/{id}', name: 'game.edit')]
    public function edit(Game $game, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Game $game
             */
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Zapisano grę.');

            return $this->redirectToRoute('game.show', ['id' => $game->getId()]); // TOOO
        }

        return $this->render('game/edit.html.twig', [
            'form' => $form,
        ]);



//
//        $game = $entityManager->getRepository(Game::class)->find($id);
//        if (!$game) {
//            throw new \RuntimeException('incorrect id');
//        }
//        $game->setScore(1);
//
////        $entityManager->persist($game);
//        $entityManager->flush();
//
//        return $this->redirectToRoute('game.show', ['id' => $game->getId()]);
//
////        return $this->render('game/show.html.twig', [
////            'game' => $game
////        ]);
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
