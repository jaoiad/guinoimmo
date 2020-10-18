<?php

namespace App\DataFixtures;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        for ($i = 1; $i <= 20; $i++) {
            $nb=rand(1,2);
            if($nb==1){
    
                $loc="maison";
            }else{
                $loc="appartement";
            }
            
            $locations = new location();
            $locations->setCreatAt(new \DateTime())
                     ->setDenomination("<p>Contenue de l'article xxxxx n°$i</p>")
                     ->setCategorie($loc)
                     ->setImage("http://via.placeholder.com/150")
                     ->setSurface(1)
                     ->setTypeMaison("1")
                     ->setChambres("2")
                     ->setEtage("2365")
                     ->setCout(1)
                     ->setAdresse("adresse")
                     ->setAccessibilite("oui");

            $manager->persist($locations);
        }
        $manager->flush();
    }
}

