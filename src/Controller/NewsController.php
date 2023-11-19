<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news.list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('news/index.html.twig', [
            'newslist' => $entityManager->getRepository(News::class)->getAllOrdered(),
        ]);
    }

    #[Route('/news/show/{id}', name: 'news.show')]
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/news/add', name: 'news.add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_MANAGE_NEWS);
        $form = $this->createForm(NewsType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var News $news
             */
            $news = $form->getData();

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'Zapisano.');

            return $this->redirectToRoute('news.show', ['id' => $news->getId()]);
        }

        return $this->render('news/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/news/edit/{id}', name: 'news.edit')]
    public function edit(EntityManagerInterface $entityManager, News $news, Request $request): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_EDIT_NEWS);
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var News $news
             */
            $news = $form->getData();

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'Zapisano zmiany.');

            return $this->redirectToRoute('news.show', ['id' => $news->getId()]);
        }

        return $this->render('news/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/news/remove/{id}', name: 'news.remove')]
    public function remove(EntityManagerInterface $entityManager, News $news): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_MANAGE_NEWS);
        $entityManager->getRepository(News::class)->delete($news, true);

        return $this->redirectToRoute('news.list');
    }
}
