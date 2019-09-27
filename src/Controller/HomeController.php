<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'messageAccueil' => 'Bienvenue sur Fou de Séries'
        ]);
    }

    /**
     * @Route("/testentity", name="testEntity")
     */
    public function testEntity()
    {
        $serie = new Serie();
        $serie->setTitre("titreTest");//setResume("lorem ipsum")->setDuree("3:00:00")->setPremiereDiffusion("03-03-2010");
        return $this->render('home/testentity.html.twig', [
            'id' => $serie->getId(),
            'titre' => $serie->getTitre()
        ]);
    }
}
