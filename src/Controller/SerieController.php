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
        $listSeries = $this->getDoctrine()->getRepository(Serie::class)->findBy(array(), array('titre' => 'ASC'));
        return $this->render('serie/index.html.twig', [
            'listSeries' => $listSeries
        ]);
    }

    /**
     * @Route("/infoserie/{id}", name="infoserie")
     */
    public function info($id)
    {
        $laSerie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
        return $this->render('serie/infoserie.html.twig', [
            'laSerie' => $laSerie
        ]);
    }
}
