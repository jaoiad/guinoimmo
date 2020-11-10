<?php

namespace App\Controller;

use App\Data\SearchData;

use App\Entity\Location;
use App\Entity\Annonces;
use App\Form\LocationType;
use App\Form\SearchType;
use App\Repository\AnnoncesRepository;
use App\Repository\LocationRepository;
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
    public function index(LocationRepository $repo, request $request)
    {

        $data=new SearchData();
        $data->page=$request->get('page',1);
        $form=$this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
    
        $coco=$repo->findSearch($data);

        
        return $this->render('home/index.html.twig', [
            'coco'=> $coco,
            'form' => $form->createView()
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
     *  @Route ("/affichage/{id}", name="affichage")
     */
    public function affichage(Location $location)
    {
        return $this->render('home/affichage.html.twig', [
            'location' => $location
        ]);
    }




    /**
     * @Route("/delete/{id}", name="ann_delete")
     */

    public function delete(Location $locations, EntityManagerInterface $delet)
    {
        $delet->remove($locations);
        $delet->flush();

        return $this->redirectToRoute('index');
    }



    /** 
     * @Route("/newlocation", name="ann_create")
     * @route ("/new/{id}", name="ann_edit")
     */

    public function newlocation(Location $locations = null, Request $request, EntityManagerInterface $entityManager)
    {

        if (!$locations) {
            $locations = new Location();
        }

        $form = $this->createForm(LocationType::class, $locations);
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {

            if (!$locations->getId()) {
                $locations->setCreatAt(new \DateTime());
            }
            $entityManager->persist($locations);
            $entityManager->flush();
            if ($locations) {
                $this->addFlash('success', 'Bien ajouter avec success');
            }
            $this->addFlash('success', 'Bien modifier avec success');


            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index', ['id' => $locations->getId()]);
        }

        return $this->render('home/create.html.twig', [
            'message1' => 'Modifier votre Location',
            'message2' => 'Ajouter une Location',
            'FormAnnonce' => $form->createView(),
            'editMode' => $locations->getId() !== null
        ]);
    }
}
