<?php

namespace App\DataFixtures;

use App\Entity\EtablissementsFrequente;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EtablissementsFrequenteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $etablissementRepository = $manager->getRepository(EtablissementsFrequente::class);

        // Vérifier si les établissements existent déjà pour ne pas les insérer plusieurs fois
        $existingEtablissements = $etablissementRepository->findAll();
        if (count($existingEtablissements) > 0) {
            // Si les établissements existent déjà, on ne fait rien
            return;
        }

        // Liste des établissements à insérer
        $etablissements = [
            'École privée Mamadou TRAORE',
            'André DAVESNE',
            'La Renaissance',
            'Goundo SIMAGA'
        ];

        // Création des établissements et ajout dans le manager
        foreach ($etablissements as $designation) {
            $etablissement = new EtablissementsFrequente();
            $etablissement->setDesignation($designation);

            // Persister chaque établissement
            $manager->persist($etablissement);
        }

        // Sauvegarder les données dans la base
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClassesFixtures::class, // Dépendance sur les fixtures des cycles
        ];
    }
}