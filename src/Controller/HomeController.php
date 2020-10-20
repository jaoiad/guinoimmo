<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Annonces;
use App\Form\LocationType;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     *
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
     * @route ("/new" , name="create")
     * @route ("/new/{id}/edit", name="edit")
     */
    public function form(Annonces $annonce, Request $request)
    {
        $entityManager = $this->entityManager;

        if(!$annonce){

            $annonce = new Annonces();
        }
    

        // Demande de al creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($annonce)
            ->add('title')
            ->add('image')
            ->add('content')
            ->getForm();

        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Affectation de la Date à mon article
            $annonce->setCreateAt(new \DateTime());

            $manager->persist($annonce);
            $manager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index', ['id' => $annonce->getId()]);
        }

        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/create.html.twig', [
            'FormAnnonce' => $form->createView()
        ]);
    }




    /** 
     * @Route("/newlocation", name="newlocation")
     * 
     */

    public function newlocation(Request $request)
    {
        $entityManager = $this->entityManager;

        $location = new Location;

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
