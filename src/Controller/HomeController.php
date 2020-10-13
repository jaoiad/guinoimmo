<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * 
     * @Route ("/", name="acceuil")
     */

    public function acceuil()
    {
        return $this->render('home/acceuil.html.twig', [
            'age'=>31
        ]);

    }



    /**
     * 
     * @Route ("/a", name="client")
     */
    public function client()
    {

        return $this->render('home/client.html.twig');
    }
}
