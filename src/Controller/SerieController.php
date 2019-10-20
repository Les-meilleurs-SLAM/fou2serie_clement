<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Entity\Genre;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="serie")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $listSeries = $this->getDoctrine()->getRepository(Serie::class)->findBy(array(), array('titre' => 'ASC'));
        foreach ($listSeries as $uneSerie) {
            if ($listSeries[0]->getId() == $uneSerie->getId()) {
                $minDuree = $uneSerie->getTempsTotal();
                $maxDuree = $minDuree;
            } else if ($minDuree > $uneSerie->getTempsTotal()) {
                $minDuree = $uneSerie->getTempsTotal();
            } else if ($maxDuree < $uneSerie->getTempsTotal()) {
                $maxDuree = $uneSerie->getTempsTotal();
            }
        }
        $listSeries = $paginator->paginate(
            $listSeries, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        $listGenres = $this->getDoctrine()->getRepository(Genre::class)->findAll();
        return $this->render('serie/index.html.twig', [
            'listSeries' => $listSeries,
            'listGenres' => $listGenres,
            'minDuree' => $minDuree,
            'maxDuree' => $maxDuree
        ]);
    }

    /**
     * @Route("/serie/{genreId}", name="serieByGenre")
     */
    public function serieByGenre(Request $request, PaginatorInterface $paginator, $genreId)
    {
        $leGenre = $this->getDoctrine()->getRepository(Genre::class)->find($genreId);
        $listSeries = $leGenre->getlesSeries();
        $listSeries = $paginator->paginate(
            $listSeries,
            $request->query->getInt('page', 1),
            6
        );

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
        $tempsTotal = $laSerie->getTempsTotal();
        $heureTotal = floor($tempsTotal / 60);
        $minuteTotal = $tempsTotal % 60;
        $lesGenres = $laSerie->getGenres();
        return $this->render('serie/infoserie.html.twig', [
            'laSerie' => $laSerie,
            'lesGenres' => $lesGenres,
            'heureTotal' => $heureTotal,
            'minuteTotal' => $minuteTotal
        ]);
    }
}
