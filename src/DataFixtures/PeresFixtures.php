<?php

namespace App\DataFixtures;

use App\Entity\Ninas;
use App\Entity\Noms;
use App\Entity\Peres;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\Entity\Telephones;
use App\Repository\NinasRepository;
use App\Repository\TelephonesRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PeresFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private TelephonesRepository $telephonesRepository, 
        private NinasRepository $ninasRepository)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
       // Charger toutes les entités nécessaires
        $noms = $manager->getRepository(Noms::class)->findAll();
        $prenoms = $manager->getRepository(Prenoms::class)->findBy(['sexe' => 'Masculin']);
        $professions = $manager->getRepository(Professions::class)
        ->findBy([], ['id' => 'DESC']); // Trie par 'id' de manière descendante
        $ninas = $manager->getRepository(Ninas::class)->findAll();
        $telephones = $this->telephonesRepository->findAll();

        // Vérification des données disponibles
        /*$minCount = min(count($noms), count($prenoms), count($professions), count($ninas), count($telephones));
        if ($minCount === 0) {
            throw new \Exception('Les données nécessaires pour générer les entités Père sont insuffisantes.');
        }*/

        // Générer les entités Père
        for ($i = 0; $i < 15; $i++) {
            // Utiliser un élément basé sur l'index de la boucle

            // Créer une nouvelle entité Père
            $pere = new Peres();
            
            $nom = $noms[$i % count($noms)]; // Choisir un nom en rotation
            $pere->setNom($nom);
            
            $prenom = $prenoms[$i % count($prenoms)]; // Choisir un prénom masculin en rotation
            $pere->setPrenom($prenom);

            $profession = $professions[$i % count($professions)]; // Rotation sur les professions
            $pere->setProfession($profession);

            $nina = $ninas[$i % count($ninas)]; // Rotation sur les NINAs
            $pere->setNina($nina);

            $telephone = $telephones[$i % count($telephones)]; // Rotation sur les téléphones
            //dump($telephone);
            $pere->setTelephone1($telephone);

            // Persist l'entité
            $manager->persist($pere);
        }

        // Sauvegarder toutes les entités en base
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StatutsElevesFixtures::class,
        ];
    }
}
