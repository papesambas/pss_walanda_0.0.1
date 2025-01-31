<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use App\Entity\Niveaux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClassesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Récupération des niveaux depuis la base
        $niveaux = $manager->getRepository(Niveaux::class)->findAll();

        // Lettres pour différencier les classes
        $lettres = ['A', 'B', 'C', 'D', 'E'];

        // Création des classes pour chaque niveau
        foreach ($niveaux as $niveau) {
            $nombreClasses = $faker->numberBetween(1, 3); // Nombre de classes par niveau

            for ($i = 0; $i < $nombreClasses; $i++) {
                $classe = new Classes();
                
                // Construction de la désignation sans le mot "Niveau"
                $designation = sprintf("%s %s", $niveau->getDesignation(), $lettres[$i % count($lettres)]);

                $classe
                    ->setDesignation($designation)
                    ->setNiveau($niveau)
                    ->setCapacite($faker->numberBetween(20, 50)) // Capacité aléatoire
                    ->setEffectif($faker->numberBetween(0, $classe->getCapacite())); // Effectif aléatoire

                $manager->persist($classe);
            }
        }

        $manager->flush(); // Enregistrement en base
    }

    public function getDependencies(): array
    {
        return [
            NiveauxFixtures::class, // Dépendance à NiveauxFixtures
        ];
    }
}
