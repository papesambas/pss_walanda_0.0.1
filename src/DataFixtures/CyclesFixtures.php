<?php

namespace App\DataFixtures;

use App\Entity\Cycles;
use App\Entity\Etablissements;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CyclesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Récupération des établissements depuis la base
        $etablissements = $manager->getRepository(Etablissements::class)->findAll();

        // Liste des désignations des cycles
        $cycleDesignations = [
            'Secondaire',
            'Fondamental 2nd Cycle',
            'Fondamental 1er Cycle',
            'Pré Scolaire',
        ];

        foreach ($etablissements as $etablissement) {
            foreach ($cycleDesignations as $designation) {
                $cycle = new Cycles();
                $cycle->setDesignation($designation);
                $cycle->setEtablissement($etablissement);
                $cycle->setCapacite($faker->numberBetween(50, 500)); // Capacité entre 50 et 500
                $cycle->setEffectif($faker->numberBetween(0, $cycle->getCapacite())); // Effectif entre 0 et capacité

                // Persist de chaque cycle
                $manager->persist($cycle);
            }
        }

        // Flush pour enregistrer tous les cycles en base
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EtablissementsFixtures::class, // Assurez-vous que cette fixture existe
        ];
    }

}
