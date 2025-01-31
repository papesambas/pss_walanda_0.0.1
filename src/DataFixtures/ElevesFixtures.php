<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Noms;
use App\Entity\Eleves;
use App\Entity\Classes;
use App\Entity\Prenoms;
use App\Entity\Etablissements;
use App\Entity\EtablissementsFrequente;
use App\Entity\LieuNaissances;
use App\Entity\Parents;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ElevesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Récupérer tous les noms, prénoms, classes, établissements et lieux de naissance
        $nomsRepository = $manager->getRepository(Noms::class);
        $prenomsRepository = $manager->getRepository(Prenoms::class);
        $classesRepository = $manager->getRepository(Classes::class);
        $etablissementsRepository = $manager->getRepository(Etablissements::class);
        $lieuNaissanceRepository = $manager->getRepository(LieuNaissances::class); // Ajout du repository LieuNaissance
        $etablissementfrequente = $manager->getRepository(EtablissementsFrequente::class); 

        $parents = $manager->getRepository(Parents::class)->findAll();

        // Obtenir les données nécessaires
        $noms = $nomsRepository->findAll();
        $prenoms = $prenomsRepository->findAll();
        $classes = $classesRepository->findAll();
        $etablissements = $etablissementsRepository->findAll();
        $lieuxNaissance = $lieuNaissanceRepository->findAll(); // Récupération des lieux de naissance
        $etablissementfrequente = $etablissementfrequente->findAll();

        // Vérifier qu'il y a suffisamment de données
        if (count($noms) === 0 || count($prenoms) === 0 || count($classes) === 0 || count($etablissements) === 0 || count($lieuxNaissance) === 0 || count($etablissementfrequente) === 0) {
            throw new \Exception("Il n'y a pas assez de données dans les entités Noms, Prenoms, Classes, Etablissements ou Lieux de Naissance.");
        }

        // Mélanger les données de façon aléatoire
        shuffle($noms);
        shuffle($prenoms);
        shuffle($lieuxNaissance);
        shuffle($etablissements);
        shuffle($classes);
        shuffle($etablissementfrequente);


        // Générer 25 élèves par classe
        foreach ($classes as $classe) {
            for ($i = 0; $i < 25; $i++) {
                $eleve = new Eleves();

                 // Assignation aléatoire d'un parent (un parent peut avoir plusieurs enfants)
                 $parent = $faker->randomElement($parents); // Associer un parent existant à l'élève

                // Assignation aléatoire d'un nom, prénom, sexe, date de naissance, lieu de naissance, établissement
                $eleve->setNom($faker->randomElement($noms))
                    ->setPrenom($faker->randomElement($prenoms))
                    ->setSexe($faker->randomElement(['M', 'F']))
                    ->setDateNaissance(new \DateTimeImmutable($faker->dateTimeBetween('-10 years', '-4 years')->format('Y-m-d'))) // Utilisation de DateTimeImmutable
                    ->setLieuNaissance($faker->randomElement($lieuxNaissance)) // Assignation d'un lieu de naissance aléatoire
                    ->setNumActe($faker->numerify('#######'))
                    ->setDateActe(new \DateTimeImmutable($faker->dateTimeThisDecade()->format('Y-m-d'))) // Utilisation de DateTimeImmutable
                    ->setEtablissement($faker->randomElement($etablissements)) // Assignation d'un établissement aléatoire
                    ->setDateRecrutement(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d'))) // Utilisation de DateTimeImmutable
                    ->setDateInscription(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d'))) // Utilisation de DateTimeImmutable
                    ->setEcoleInscription($faker->randomElement($etablissementfrequente)) // Assignation d'un établissement aléatoire pour l'école d'inscription
                    ->setClasse($classe)
                    ->setParent($parent); // Assignation à la classe

                // Persister l'élève
                $manager->persist($eleve);
            }
        }

        // Sauvegarder les données en base
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            Scolarites1Fixtures::class, // Assurez-vous que la fixture des parents existe et est bien définie
        ];
    }
}