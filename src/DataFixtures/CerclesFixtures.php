<?php

namespace App\DataFixtures;

use App\Entity\Cercles;
use App\Entity\Regions;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CerclesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $regions = $manager->getRepository(Regions::class)->findAll();

        $cercleCounter = 1; // Compteur global pour assurer l'unicité des cercles
        foreach ($regions as $region) {
            for ($i = 1; $i <= 10; $i++) {
                $cercle = new Cercles();
                $cercle->setDesignation("Cercle " . $cercleCounter); // Utilisation du compteur global
                $cercle->setRegion($region);
                $manager->persist($cercle);

                $cercleCounter++; // Incrémenter le compteur global
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RegionsFixtures::class
        ];
    }
}
