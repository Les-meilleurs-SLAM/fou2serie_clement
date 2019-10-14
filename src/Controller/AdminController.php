<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
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
}