<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Cycles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use Faker\Factory as Faker;
use App\Entity\Enseignements;
use App\Entity\Etablissements;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EnseignementsFixtures extends Fixture implements DependentFixtureInterface
{
    public const ENSEIGNEMENTS_REFERENCE = 'enseignementsEntity';

    public function load(ObjectManager $manager): void
    {
        $EnseignementsType = $manager->getRepository(Enseignements::class)->findAll();

        $faker = Factory::create();
        // Exemple pour générer des adresses et contacts fictifs
        $address = $faker->address();
        $telephone = $faker->phoneNumber;

        $EnseignementsType = [
            'Enseignement Classique',
            'Enseignement Franco-Arabe',
            'Enseignement Spécialisé'
        ];

        // Capacités et effectifs dynamiques
        $capacites = [
            'Enseignement Classique' => 30,
            'Enseignement Franco-Arabe' => 40,
            'Enseignement Spécialisé' => 25
        ];

        $effectifs = [
            'Enseignement Classique' => 25,
            'Enseignement Franco-Arabe' => 35,
            'Enseignement Spécialisé' => 20
        ];

        // Créer les types d'enseignement
        foreach ($EnseignementsType as $designation) {
            $enseignementsEntity = new Enseignements();
            $enseignementsEntity->setDesignation($designation)
                ->setCapacite($capacites[$designation])
                ->setEffectif($effectifs[$designation]);

            // Enregistrer l'entité Enseignement
            $manager->persist($enseignementsEntity);

            // Assigner une référence unique pour chaque type d'enseignement
            $this->setReference('enseignements_' . strtolower(str_replace(' ', '_', $designation)), $enseignementsEntity);

        }

        $manager->flush();
    }



    public function getDependencies(): array
    {
        return [
            ParentsFixtures::class, // Assurez-vous que la fixture des parents existe et est bien définie
        ];
    }
}
