<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', 'index.home')]
    public function home(): Response
    {
        return $this->render('index/home.html.twig');
    }

    #[Route('/about', 'index.about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }

    #[Route('/hello/{firstName}', 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = 'Guest'): Response
    {
        $favoriteGames = [
            'AoE 2',
            'LOL'
        ];

        return $this->render('index/hello.html.twig', [
            'firstName' => $firstName,
            'favoriteGames' => $favoriteGames
        ]);
    }

    #[Route('/top', 'index.top')]
    public function top()
    {
        $games = [
            'AoE 2',
            'LOL'
        ];

        return new JsonResponse($games);
    }
}