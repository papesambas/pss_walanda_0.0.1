<?php

namespace App\DataFixtures;

use App\Entity\Cercles;
use App\Entity\Communes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommunesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cercles = $manager->getRepository(Cercles::class)->findAll();
        $communeCounter = 1;

        foreach ($cercles as $cercle) {
            for ($j = 1; $j <= 20; $j++) {
                $commune = new Communes();
                $commune->setDesignation("Commune " . $communeCounter);
                $commune->setCercle($cercle);
                $manager->persist($commune);

                $communeCounter ++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CerclesFixtures::class
        ];
    }

}
