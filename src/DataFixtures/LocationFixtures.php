<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Location;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class LocationFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //creation de fausse données : 3 categorie 
        for ($i = 1; $i <= 3; $i++) {
            $cat = new Categorie();
            $cat  -> setTitre($faker->sentence());
            $cat -> setDescription($faker->text($maxNbChars = 10));
                        
            $manager -> persist($cat);

            for ($j = 1; $j <= 10; $j++) {
             $arrray = array('Maison de ville', 'maison village','villa', 'appartement');
             $melange=shuffle($arrray);  
             $loc = new location();
                
                    $loc->setCreatAt(new \DateTime())
                              ->setDenomination($faker->sentence($nb = 5, $asText = false))
                              ->setImage($faker->imageUrl($width = 640, $height = 480) )
                              ->setSurface($faker->numberBetween(10,500))
                              ->setTypeMaison($melange)
                              ->setChambres($faker->numberBetween(1,5))
                              ->setEtage($faker->numberBetween(1,5))
                              ->setCout($faker->numberBetween(500,1200))
                              ->setAdresse($faker->streetAddress())
                              ->setAccessibilite($faker -> boolean)
                              ->setCategories($cat);
    
                    $manager->persist($loc);
                }
        }

            $manager->flush();
        }
    }

