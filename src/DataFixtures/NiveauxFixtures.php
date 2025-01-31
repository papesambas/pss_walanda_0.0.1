<?php

namespace App\DataFixtures;

use App\Entity\Cycles;
use App\Entity\Niveaux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NiveauxFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Récupération des cycles depuis la base
        $cycles = $manager->getRepository(Cycles::class)->findAll();

        // Définitions des niveaux par type de cycle
        $niveauxSecondaire = [
            '12ème Année',
            '11ème Année',
            '10ème Année',
        ];

        $niveauxFondamental2nd = [
            '9ème Année',
            '8ème Année',
            '7ème Année',
        ];

        $niveauxFondamental1er = [
            '6ème Année',
            '5ème Année',
            '4ème Année',
            '3ème Année',
            '2ème Année',
            '1ère Année',
        ];

        $niveauxPreScolaire = [
            'Petite Section',
            'Moyenne Section',
            'Grande Section'
        ];

        foreach ($cycles as $cycle) {
            $designation = $cycle->getDesignation(); // Récupération de la désignation du cycle

            $niveauxToCreate = [];
            if ($designation === 'Secondaire') {
                $niveauxToCreate = $niveauxSecondaire;
            } elseif ($designation === 'Fondamental 2nd Cycle') {
                $niveauxToCreate = $niveauxFondamental2nd;
            } elseif ($designation === 'Fondamental 1er Cycle') {
                $niveauxToCreate = $niveauxFondamental1er;
            } elseif ($designation === 'Pré Scolaire') {
                $niveauxToCreate = $niveauxPreScolaire;
            }

            // Création des entités Niveaux pour ce cycle
            foreach ($niveauxToCreate as $niveauDesignation) {
                $niveau = new Niveaux();
                $niveau->setDesignation($niveauDesignation)
                    ->setCycle($cycle)
                    ->setCapacite($faker->numberBetween(20, 50)) // Exemple : capacité aléatoire
                    ->setEffectif($faker->numberBetween(0, $niveau->getCapacite())); // Exemple : effectif aléatoire

                $manager->persist($niveau);
            }
        }

        $manager->flush(); // Enregistrement des entités en base
    }

    public function getDependencies(): array
    {
        return [
            CyclesFixtures::class, // Dépendance sur les fixtures des cycles
        ];
    }
}
