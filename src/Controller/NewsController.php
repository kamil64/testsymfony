<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function add(EntityManagerInterface $entityManager): Response
    {
        return $this->render('news/add.html.twig');
    }

    #[Route('/news/edit/{id}', name: 'news.edit')]
    public function edit(EntityManagerInterface $entityManager, News $news): Response
    {
        return $this->render('news/edit.html.twig', [
            'news' => $news
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/news/update/{id}', name: 'news.update')]
    public function update(EntityManagerInterface $entityManager, News $news): Response
    {
        if (!isset($_POST['content'], $_POST['title'], $_POST['date'])) {
            throw new \InvalidArgumentException('One or more required parameters are missing.');
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date'])) {
            throw new \InvalidArgumentException('The content must be in the format Y-m-d.');
        }

        $news->setContent($_POST['content'])
            ->setTitle($_POST['title'])
            ->setDate(new \DateTime($_POST['date']));

        $entityManager->getRepository(News::class)->save($news, true);

        return $this->redirectToRoute('news.show', ['id' => $news->getId()]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/news/save', name: 'news.save')]
    public function save(EntityManagerInterface $entityManager): Response
    {
        if (!isset($_POST['content'], $_POST['title'], $_POST['date'])) {
            throw new \InvalidArgumentException('One or more required parameters are missing.');
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date'])) {
            throw new \InvalidArgumentException('The content must be in the format Y-m-d.');
        }

        $news = (new News)
            ->setContent($_POST['content'])
            ->setTitle($_POST['title'])
            ->setDate(new \DateTime($_POST['date']));

        $entityManager->getRepository(News::class)->save($news, true);

        return $this->redirectToRoute('news.show', ['id' => $news->getId()]);
    }

    #[Route('/news/remove/{id}', name: 'news.remove')]
    public function remove(EntityManagerInterface $entityManager, News $news): Response
    {
        $entityManager->getRepository(News::class)->delete($news, true);

        return $this->redirectToRoute('news.list');
    }
}
