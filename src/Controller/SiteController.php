<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'title' => 'Accueil',
        ]);
    }

    /**
     * @Route("/deroulement", name="usage")
     */
    public function usage()
    {
        return $this->render('site/index.html.twig', [
            'title' => 'Déroulement',
        ]);
    }

    /**
     * @Route("/vote", name="vote")
     */
    public function vote()
    {
        return $this->render('site/index.html.twig', [
            'title' => 'Vote',
        ]);
    }

    /**
     * @Route("/mode", name="mode")
     */
    public function code()
    {
        return $this->render('site/index.html.twig', [
            'title' => 'Mode élection',
        ]);
    }
}
