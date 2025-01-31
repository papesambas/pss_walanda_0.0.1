<?php

namespace App\DataFixtures;

use App\Entity\Noms;
use App\Entity\Prenoms;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PrenomsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Prénoms
        $prenomsHommeMali = [
            'Adama', 'Amadou', 'Oumar', 
            'Issa', 'Alou', 'Moussa', 'Bakary', 'Abdoulaye', 'Seydou',
            'Boubacar', 'Cheick', 'Tiemoko', 'Ibrahime', 'Mamadou',
            'Kouadio', 'Souleymane', 'Djibril', 'Yacouba', 'Alioune', 'Boubou', 'Karamoko',
            'Demba', 'Tidiane', 'Fousseyni', 'Youssouf', 'Karim', 'Khalil', 
            'Ousmane', 'Lassana', 'Ibrahima', 'Sory', 'N’fa', 
            'Makene', 'Baya', 'Abdou', 'Mouhamed', 'Kassoum', 'Lamine',
            'Sekou', 'Alassane', 'Modibo', 'Fadel', 'Alhassane', 'Ba',
            'Maga', 'Nabi', 'Mohamed', 'Diakite',
        ];

        $prenomsFemmesMali = [
            'Fatoumata', 'Mariama', 'Kadiatou', 'Sadio', 'Mariam',
            'Djeneba', 'Nafissatou', 
            'Alima', 'Oumou',  'Sira', 'Coumba',
            'Tanty','Sogolon',  'Sokhna',
            'Fanta', 'Maminata',  'Bintou', 'Yacine',
            'Nana',  'Aissatou',  'Zena', 'Aminata', 'Fatou','Seynabou',
        ];

        foreach ($prenomsHommeMali as $index => $prenomHomme) {
            $prenomEntity = new Prenoms();
            $prenomEntity->setDesignation($prenomHomme);
            $prenomEntity->setSexe('Masculin');

            // Assigner un nom différent à chaque prénom
            // Vous pouvez utiliser l'indice de la boucle pour récupérer un nom spécifique dans le tableau
            //$nom = $noms[$index % count($noms)]; // Utiliser un nom à chaque itération
            //dump($nom);  // Cela affichera un nom différent à chaque itération
    
            $manager->persist($prenomEntity);
            $this->setReference('prenom_' . $index, $prenomEntity);
        }

        foreach ($prenomsFemmesMali as $index => $prenomFemme) {
            $prenomEntity = new Prenoms();
            $prenomEntity->setDesignation($prenomFemme);
            $prenomEntity->setSexe('Féminin');

            // Assigner un nom différent à chaque prénom
            // Vous pouvez utiliser l'indice de la boucle pour récupérer un nom spécifique dans le tableau
            //$nom = $noms[$index % count($noms)]; // Utiliser un nom à chaque itération
            //dump($nom);  // Cela affichera un nom différent à chaque itération
    
            $manager->persist($prenomEntity);
            $this->setReference('prenom_' . $index, $prenomEntity);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NomsFixtures::class,
        ];
    }
}
