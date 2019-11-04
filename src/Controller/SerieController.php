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
                $minDuree = $uneSerie->getDuree();
                $maxDuree = $minDuree;
            } else if ($minDuree > $uneSerie->getDuree()) {
                $minDuree = $uneSerie->getDuree();
            } else if ($maxDuree < $uneSerie->getDuree()) {
                $maxDuree = $uneSerie->getDuree();
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
     * @Route("/serieByDuree/{duree}", name="serieByDuree")
     */
    public function serieByDuree($duree, Request $request, PaginatorInterface $paginator)
    {
        $listSeries = $this->getDoctrine()->getRepository(Serie::class)->getSerieByDuree($duree);
        $minDuree = 0;
        $maxDuree = 0;
        foreach ($listSeries as $uneSerie) {
            if ($listSeries[0]->getId() == $uneSerie->getId()) {
                $minDuree = $uneSerie->getDuree();
                $maxDuree = $minDuree;
            } else if ($minDuree > $uneSerie->getDuree()) {
                $minDuree = $uneSerie->getDuree();
            } else if ($maxDuree < $uneSerie->getDuree()) {
                $maxDuree = $uneSerie->getDuree();
            }
        }
        $listSeries = $paginator->paginate(
            $listSeries,
            $request->query->getInt('page', 1),
            6
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
     * @Route("/serieByGenre/{genreId}", name="serieByGenre")
     */
    public function serieByGenre(Request $request, PaginatorInterface $paginator, $genreId)
    {
        $leGenre = $this->getDoctrine()->getRepository(Genre::class)->find($genreId);
        $listSeries = $leGenre->getlesSeries();
        foreach ($listSeries as $uneSerie) {
            if ($listSeries[0]->getId() == $uneSerie->getId()) {
                $minDuree = $uneSerie->getDuree();
                $maxDuree = $minDuree;
            } else if ($minDuree > $uneSerie->getDuree()) {
                $minDuree = $uneSerie->getDuree();
            } else if ($maxDuree < $uneSerie->getDuree()) {
                $maxDuree = $uneSerie->getDuree();
            }
        }
        $listSeries = $paginator->paginate(
            $listSeries,
            $request->query->getInt('page', 1),
            6
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
