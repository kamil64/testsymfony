<?php
namespace App\Controller;

use App\Service\CodeGenerator;
use Exception;
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
        return $this->render('index/hello.html.twig', [
            'firstName' => $firstName,
            'favoriteGames' => $this->getGames()
        ]);
    }

    #[Route('/top', 'index.top')]
    public function top(): JsonResponse
    {
        return new JsonResponse($this->getGames());
    }

    #[Route('/topgame', 'index.topgame')]
    public function topGame(): Response
    {
        return $this->render('index/topgame.html.twig', [
            'favoriteGames' => $this->getGames()
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/code', 'index.code')]
    public function code(CodeGenerator $codeGenerator): Response
    {
        $code = $codeGenerator->generate();
        return $this->render('index/code.html.twig', [
            'code' => $code
        ]);
    }

    /**
     * @return string[]
     */
    protected function getGames(): array
    {
        return [
            'AoE 2',
            'LOL'
        ];
    }
}