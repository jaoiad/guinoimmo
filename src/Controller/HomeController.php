<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Persistence\ObjectManager;

class HomeController extends AbstractController
{
    protected $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route ("/accueil", name="accueil")
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
     * @route ("/new" , name="")
     */
    public function create(Request $request)
    {
        $entityManager = $this->entityManager;
        $annonce = new Annonces();
        $form = $this->createformbuilder($annonce)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Affectation de la Date à mon article
            $annonce->setCreateAt(new \DateTime());

            $entityManager->persist($annonce);
            $entityManager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index', ['id' => $annonce->getId()]);
        }


        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/create.html.twig', [
            'formarticle' => $form->createView()
        ]);
    }


    /** 
     * @Route("/newlocation", name="newlocation")
     */

    public function newlocation(Request $request)
    {
        $entityManager = $this->entityManager;

        $location = new Location;
        // j'appelle la classe location type pour mes champs
        $form = $this->createForm(LocationType::class, $location);
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);
        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            $location->setCreatAt(new \DateTime());
            $entityManager->persist($location);
            $entityManager->flush();
        }



        return $this->render('home/newlocation.html.twig', [
            'newlocation' => $form->createView()
        ]);
    }
}
