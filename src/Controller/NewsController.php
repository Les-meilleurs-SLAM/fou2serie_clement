<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index()
    {
        $listNews = $this->getDoctrine()->getRepository(Serie::class)->getListNews();
        return $this->render('news/index.html.twig', [
            'messageAccueil' => 'Bienvenue sur les news',
            'listNews' => $listNews
        ]);
    }
}