<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $lastArticles = $articleRepository->findLast(Article::NB_HOME);

        return $this->render('index/index.html.twig', [
            'last_articles' => $lastArticles,
        ]);
    }
}
