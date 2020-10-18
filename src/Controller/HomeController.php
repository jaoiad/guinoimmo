<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use doctrine\Common\Persistence\ObjectManager;
use App\Repository\AnnoncesRepository;
use Symfony\component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HomeController extends AbstractController
{



    /**
     * @Route("/home", name="home")
     */
    public function index(AnnoncesRepository $repo)
    {
        $repo = $this->getDoctrine()->getRepository(Annonces::class);
        $annonce = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'annonce' => $annonce
        ]);
    }
    /**
     * 
     * @Route ("/accueil", name="accueil")
     */

    public function accueil()
    {
        return $this->render('home/index.html.twig', []);
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
     *  @Route ("/affichage/{id}", name="affichage")
     */
    public function affichage(Annonces $annonce)
    {


        return $this->render('home/affichage.html.twig', [
            'annonce' => $annonce
        ]);
    }


    /**
     * @route ("/new" , name="create")
     */
    public function create(Request $request, ObjectManager $manager)
    {

        $annonce = new Annonces();
        $form = $this->createformbuilder($annonce)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();
        $form->handleRequest($request);
        dump($annonce);
        return $this->render('home/create.html.twig', [
            'formarticle' => $form->createView()
        ]);
    }
}
