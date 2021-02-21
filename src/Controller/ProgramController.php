<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Undocumented class
 * @Route("/program", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Serie'
        ]);
    }

    /**
     * @Route("/show/{page}", methods={"GET"}, requirements={"page"="\d+"}, name="show")
     */
    public function show(int $page): Response
    {
        return $this-> render('program/show.html.twig', [
            'page' => $page
        ]);
    }
}