<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Entity\Genre;

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
        $lesGenresId = $laSerie->getGenres();
        $lesGenres = array();
        $i = 0;
        foreach ($lesGenresId as $unGenreId) {
            $lesGenres[$i] = $this->getDoctrine()->getRepository(Genre::class)->find($unGenreId);
            $i++;
        }
        return $this->render('serie/infoserie.html.twig', [
            'laSerie' => $laSerie,
            'lesGenres' => $lesGenres
        ]);
    }
}
