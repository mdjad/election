<?php

namespace App\Controller;

use App\Entity\Electeur;
use App\Form\ElecteurType;
use App\Repository\ElecteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/electeur")
 */
class ElecteurController extends AbstractController
{
    /**
     * @Route("/", name="electeur_index", methods={"GET"})
     */
    public function index(ElecteurRepository $electeurRepository): Response
    {
        return $this->render('electeur/index.html.twig', [
            'electeurs' => $electeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="electeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $electeur = new Electeur();
        $form = $this->createForm(ElecteurType::class, $electeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electeur);
            $entityManager->flush();

            return $this->redirectToRoute('electeur_index');
        }

        return $this->render('electeur/new.html.twig', [
            'electeur' => $electeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="electeur_show", methods={"GET"})
     */
    public function show(Electeur $electeur): Response
    {
        return $this->render('electeur/show.html.twig', [
            'electeur' => $electeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="electeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Electeur $electeur): Response
    {
        $form = $this->createForm(ElecteurType::class, $electeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('electeur_index', [
                'id' => $electeur->getId(),
            ]);
        }

        return $this->render('electeur/edit.html.twig', [
            'electeur' => $electeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="electeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Electeur $electeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$electeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($electeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('electeur_index');
    }
}
