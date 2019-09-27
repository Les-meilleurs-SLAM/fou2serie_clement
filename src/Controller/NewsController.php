<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index()
    {
        $nbNews = 10;
        return $this->render('news/news.html.twig', [
            'messageAccueil' => 'Bienvenue sur les news',
            'nombreNews' => $nbNews
        ]);
    }
}