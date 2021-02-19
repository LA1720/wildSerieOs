<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * Undocumented function
     * @Route("/", name="app_index")
     *
     * @return void
     */
    public function index()
    {
        return $this->render("index.html.twig", [
            'welcome' => 'Bienvenue!'
        ]);
    }
}