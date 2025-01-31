<?php

namespace App\DataFixtures;

use App\Entity\Enseignements;
use App\Entity\Etablissements;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EtablissementsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create();
        $formeJuridiques = ['SARL', 'SA', 'Association', 'Coopérative']; // Exemple de formes juridiques

        // Récupération des enseignements depuis la base
        $enseignements = $manager->getRepository(Enseignements::class)->findAll();

        foreach ($enseignements as $enseignement) {
            $designation = $enseignement->getDesignation();
            
            // Générer les établissements pour chaque type d'enseignement
            $this->createEtablissements($manager, $designation, $enseignement, $formeJuridiques, $faker);
        }

        // Persist toutes les entités créées
        $manager->flush();
    }

    private function createEtablissements(
        ObjectManager $manager,
        string $type,
        Enseignements $enseignement,
        array $formeJuridiques,
        \Faker\Generator $faker
    ): void {
        // Ajout d'un établissement spécifique pour l'enseignement classique
        if ($type === 'Enseignement Classique') {
            $this->persistEtablissement(
                $manager,
                $enseignement,
                'Ecole privée Mamadou TRAORE',
                $formeJuridiques[array_rand($formeJuridiques)],
                $faker
            );
        }

        // Générer 5 établissements supplémentaires pour ce type
        for ($i = 1; $i <= 5; $i++) {
            $designation = $type . ' ' . $i;
            $forme = $formeJuridiques[array_rand($formeJuridiques)];

            $this->persistEtablissement($manager, $enseignement, $designation, $forme, $faker);
        }
    }

    private function persistEtablissement(
        ObjectManager $manager,
        Enseignements $enseignement,
        string $designation,
        string $formeJuridique,
        \Faker\Generator $faker
    ): void {
        $etablissement = new Etablissements();
        $etablissement
            ->setDesignation($designation)
            ->setFormeJuridique($formeJuridique)
            ->setNumDecisionCreation($this->generateDecisionNumber())
            ->setNumDecisionOuverture($this->generateDecisionNumber())
            ->setDateOuverture(new \DateTimeImmutable())
            ->setAdresse($faker->address())
            ->setTelephone('(223) ' . $faker->phoneNumber)
            ->setEmail('contact@' . strtolower(str_replace(' ', '', $designation)) . '.com')
            ->setEnseignement($enseignement)
            ->setCapacite($faker->numberBetween(30, 50)) // Dynamique
            ->setEffectif($faker->numberBetween(30, $etablissement->getCapacite())); // Dynamique

        $manager->persist($etablissement);
    }

    private function generateDecisionNumber(): string
    {
        $prefix = 'MLI';
        $randomNumber = rand(1000, 9999);
        $randomCode = strtoupper(substr(md5(uniqid()), 0, 3));
        $year = date('Y');

        return "{$prefix}-{$randomNumber}-{$randomCode}-{$year}";
    }

    public function getDependencies(): array
    {
        return [
            EnseignementsFixtures::class, // Assurez-vous que cette fixture existe
        ];
    }
}
