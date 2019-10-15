<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Entity\Genre;
use App\Form\GenreType;
use App\Form\SerieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $listSeries = $this->getDoctrine()->getRepository(Serie::class)->findBy(array(), array('titre' => 'ASC'));
        return $this->render('admin/index.html.twig', [
            'listSeries' => $listSeries,
        ]);
    }

    /**
     * @Route("/admin/{id}", name="editer")
     */
    public function editer($id, Request $request)
    {
        $laSerie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
        $form = $this->createForm(SerieType::class, $laSerie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/editer.html.twig', [
            'laSerie' => $laSerie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request)
    {
        $serie = new Serie;
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer($id)
    {
        $laSerie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
        return $this->render('admin/supprimer.html.twig', [
            'laSerie' => $laSerie
        ]);
    }

    /**
     * @Route("/supprimerOK/{id}", name="supprimerOK")
     */
    public function supprimerOK($id, Request $request)
    {
        $laSerie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid($laSerie->getId(), $submittedToken)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($laSerie);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/ajouterGenre", name="ajouterGenre")
     */
    public function ajouterGenre(Request $request)
    {
        $genre = new Genre;
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/ajouterGenre.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
