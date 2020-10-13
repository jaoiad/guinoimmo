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
     * @Route ("/", name="accueil")
     */

    public function acceuil()
    {
        return $this->render('home/index.html.twig', [
            'day' => 'mardi'
        ]);
    }

    /**
     * 
     * @route ("/terrain", name="terrain")
     */

    public function ventes()
    {
        return $this->render('home/terrain.html.twig');
    }


    /**
     * 
     * @Route ("/appartement", name="appartement")
     */
    public function location()
    {

        return $this->render('home/appartement.html.twig');
    }


    /**
     * 
     * @Route ("/test", name="test")
     */
    public function test()
    {

        return $this->render('home/test.html.twig');
    }


    /**
     * 
     * @Route ("/administration", name="administration")
     */
    public function administration()
    {

        return $this->render('home/administration.html.twig');
    }


    /**
     * 
     * @Route ("/connexion", name="connexion")
     */
    public function connexion()
    {

        return $this->render('home/connexion.html.twig');
    }


    /**
     * 
     *  @Route ("/affichage", name="affichage")
     */
    public function affichage()
    {
        return $this->render('home/affichage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
