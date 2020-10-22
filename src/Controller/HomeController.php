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
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;

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
     * @route ("/new" , name="ann_create")
     * @route ("/new/{id}", name="ann_edit")
     */
    public function form(Annonces $annonce = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$annonce) {
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

            if (!$annonce->getId()){
                $annonce->setCreateAt(new \DateTime());
            }

            $manager->persist($annonce);
            $manager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index', ['id' => $annonce->getId()]);
        }

        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/create.html.twig', [
            'FormAnnonce' => $form->createView(),
            'editMode'=>$annonce ->getId()!== null
        ]);
    }


    /**
     * @Route("new/{id}/delete", name="ann_delete")
     */

     
    public function delete(Annonces $annonce, Request $request, EntityManagerInterface $Manager )
    {
        $annonce = new Annonces();
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $Manager = $this->getDoctrine()->getManager();
            $Manager->remove($annonce);
            $Manager->flush();
        }
        return $this->redirectToRoute('index');
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
