<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        //create new program object//
        $program = new Program();

        //Create a form to use Program entity//
        $form = $this->createForm(ProgramType::class, $program);

        //push the program form to http foundation request method//
        $form->handleRequest($request);

        //if press send button//
        if($form->isSubmitted()){

            //make connection with database for persist//
            $entityManager = $this->getDoctrine()->getManager();

            //persist form data into the Program entity in database //
            $entityManager->persist($program);


            $entityManager->flush();

            
            return $this->redirectToRoute('program_home');

        }

        return $this->render('program/new.html.twig', [
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * 
     */
    public function show(Program $program): Response
    {
        
        // $program = $programRepository->findOneBy(['id'=>$id]);

        if(!$program){
            throw $this->createNotFoundException(
                'No Program with id : ' .$program. ' found in program\'s table.'
            );
            
        }
        $season = $program->getSeasons();
        return $this-> render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $season
        ]);
    }

    /**
     * @Route("/{program_id}/seasons/{season_id}", requirements={"season_id"="\d+"}, methods={"GET"}, name="season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping":{"program_id":"id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping":{"season_id":"id"}})
     */

    public function showSeason(Program $program, Season $season)
    {   



       $episodes = $season->getEpisodes();

       return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
       ]);
    }


    /**
     * @Route("/{program_id}/seasons/{season_id}/episodes/{episode_id}", requirements={"season_id"="\d+", "episode_id"="\d+"}, methods={"GET"}, name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping":{"program_id":"id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping":{"season_id":"id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping":{"episode_id":"id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('episode/show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}