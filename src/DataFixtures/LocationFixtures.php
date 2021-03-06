<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Location;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\shuffle_extra;

class LocationFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //creation de fausse données : 3 categorie 
        for ($i = 0; $i <= 3; $i++) {
            $cat = new Categorie();
            $arrray1 = array('Hotel', 'Terrain', 'Maison', 'Appartement');

            $cat  -> setTitre($arrray1[$i]);
            $cat -> setDescription($faker->text($maxNbChars = 10));
                        
            $manager -> persist($cat);

            for ($j = 0; $j <= 10; $j++) {
             $arrray = array('Maison de ville', 'maison village','villa', 'appartement');
             
             $loc = new location();
                
                    $loc->setCreatAt(new \DateTime())
                              ->setDenomination($faker->sentence($nb = 5, $asText = false))
                              ->setimagefile($faker->imageUrl($width = 200, $height = 200) )
                              ->setSurface($faker->numberBetween(10,500))
                              ->setTypeMaison($arrray[$i])
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

