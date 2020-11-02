<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Annonces;

class AnnoncesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $annonces = new Annonces();
            $annonces->setTitle("annonce n°$i")
                     ->setContent("<p>Contenue de l'article xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx n°$i</p>")
                     ->setImage("http://via.placeholder.com/150")
                     ->setCreateAt(new \DateTime());

            $manager->persist($annonces);
        }
        $manager->flush();
    }
}
