<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{

    /**
     * Undocumented function
     * @Route("/", name="index")
     *
     * @param CategoryRepository $categoryRepository
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $category
        ]);

    
    }


    /**
     * @Route("/new", name="new")
     *
     * @return void
     */
    public function new(Request $request)
    {   
        //Create a new category object
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView() 
        ]);


    }
    /**
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name'=>$categoryName]);
        
        $programs = $this->getDoctrine()->getRepository(Program::class)->findBy(['Category'=> $category]);

        if(!$category) {
            throw $this->createNotFoundException(
                ''.$categoryName.' n\'existe pas'
            );  
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs
        ]);
        
    }
}