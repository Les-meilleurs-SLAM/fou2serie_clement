<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="serie")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $listSeries = $repository->findAll();
        return $this->render('serie/index.html.twig', [
            'listSeries' => $listSeries
        ]);
    }
}
