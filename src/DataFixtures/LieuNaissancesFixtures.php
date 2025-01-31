<?php

namespace App\DataFixtures;

use App\Entity\Communes;
use App\Entity\LieuNaissances;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use PeresFixtures;

class LieuNaissancesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $communes = $manager->getRepository(Communes::class)->findAll();

        $quartierCounter = 1;

        foreach ($communes as $commune) {
            for ($k = 1; $k <= 15; $k++) {
                $quartier = new LieuNaissances();
                $quartier->setDesignation("Quartier " . $quartierCounter);
                $quartier->setCommune($commune);
                $manager->persist($quartier);

                $quartierCounter++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CommunesFixtures::class
        ];
    }

}
