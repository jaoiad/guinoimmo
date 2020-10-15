<?php

namespace App\DataFixtures;

use App\Entity\Immo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImmoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $annonces = new Immo();
            $annonces->setTitle("annonce n°$i")
                     ->setContent("<p>Contenue de l'article n°$i</p>")
                     ->setImage("http://via.placeholder.com/150")
                     ->setcreatAt(new \DateTime());

            $manager->persist($annonces);
        }
        $manager->flush();
    }
}
