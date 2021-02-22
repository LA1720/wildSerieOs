<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
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
     * show all rows from Program's entity
     * @Route("/", name="home")
     * @return Response A response intance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/show/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        
        $program = $programRepository->findOneBy(['id'=>$id]);

        if(!$program){
            throw $this->createNotFoundException(
                'No Program with id : ' .$id. ' found in program\'s table.'
            );
            
        }

        return $this-> render('program/show.html.twig', [
            'program' => $program
        ]);
    }
}