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
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;

class HomeController extends AbstractController
{
    
    /**
     * @param
     * @Route ("/accueil", name="accueil")
     * @Route("/home", name="home")
     */
    public function index(AnnoncesRepository $repo, PaginatorInterface $paginator, request $request)
    {
        $annonce = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1),/*page number*/
            9/*limit per page*/
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'annonce' => $annonce
        ]);
    }

    /**
     * 
     * @route ("/terrain", name="terrain")
     * d
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

            if (!$annonce->getId()) {
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
            'editMode' => $annonce->getId() !== null
        ]);
    }


    /**
     * @Route("/delete/{id}", name="ann_delete")
     * 
     */

    public function delete(Annonces $annonce, EntityManagerInterface $delet)
    {
            $delet->remove($annonce);
            $delet->flush();
        
        return $this->redirectToRoute('index');
    }



    /** 
     * @Route("/newlocation", name="newlocation")
     * @Route("/newlocation", name="newlocation")
     */

    public function newlocation(Location $locations=null, Request $request,EntityManagerInterface $entityManager)
    {
      
    
            $locations = new Location();
        
      

        $form = $this->createForm(LocationType::class, $locations);
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);


        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            $locations->setCreatAt(new \DateTime());
            $entityManager->persist($locations);
            $entityManager->flush();
        }



        return $this->render('home/newlocation.html.twig', [
            'newlocation' => $form->createView()
        ]);
    }
}
