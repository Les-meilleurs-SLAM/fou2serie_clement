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
        $listGenres = $this->getDoctrine()->getRepository(Genre::class)->findAll();
        return $this->render('serie/index.html.twig', [
            'listSeries' => $listSeries,
            'listGenres' => $listGenres
        ]);
    }

    /**
     * @Route("/serie/{genreId}", name="serieByGenre")
     */
    public function serieByGenre($genreId)
    {
        $leGenre = $this->getDoctrine()->getRepository(Genre::class)->find($genreId);
        $listSeries = $leGenre->getlesSeries();
        $listGenres = $this->getDoctrine()->getRepository(Genre::class)->findAll();
        return $this->render('serie/index.html.twig', [
            'listSeries' => $listSeries,
            'listGenres' => $listGenres
        ]);
    }

    /**
     * @Route("/infoserie/{id}", name="infoserie")
     */
    public function info($id)
    {
        $laSerie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
        $lesGenres = $laSerie->getGenres();
        return $this->render('serie/infoserie.html.twig', [
            'laSerie' => $laSerie,
            'lesGenres' => $lesGenres
        ]);
    }
}
