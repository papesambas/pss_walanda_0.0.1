<?php

namespace App\DataFixtures;

use App\Entity\Noms;
use App\Entity\Ninas;
use App\Entity\Peres;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\DataFixtures\PeresFixtures;
use App\Entity\Meres;
use App\Repository\NinasRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\TelephonesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MeresFixtures extends Fixture implements DependentFixtureInterface
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
        $prenoms = $manager->getRepository(Prenoms::class)->findBy(['sexe' => 'Féminin']);
        $professions = $manager->getRepository(Professions::class)->findAll();
        $ninas = $this->ninasRepository->findAll(11);
        $telephones = $this->telephonesRepository->findAll(11);

        // Vérification des données disponibles
        /*$minCount = min(count($noms), count($prenoms), count($professions), count($ninas), count($telephones));
        if ($minCount === 0) {
            throw new \Exception('Les données nécessaires pour générer les entités Père sont insuffisantes.');
        }*/

        // Générer les entités Père
        for ($i = 0; $i < 15; $i++) {
            // Utiliser un élément basé sur l'index de la boucle

            // Créer une nouvelle entité Père
            $mere = new Meres();
            
            $nom = $noms[$i % count($noms)]; // Choisir un nom en rotation
            $mere->setNom($nom);
            
            $prenom = $prenoms[$i % count($prenoms)]; // Choisir un prénom masculin en rotation
            $mere->setPrenom($prenom);

            $profession = $professions[$i % count($professions)]; // Rotation sur les professions
            $mere->setProfession($profession);

            $nina = $ninas[$i % count($ninas)]; // Rotation sur les NINAs
            $mere->setNina($nina);

            $telephone = $telephones[$i % count($telephones)]; // Rotation sur les téléphones
            //dump($telephone);
            $mere->setTelephone1($telephone);

            // Persist l'entité
            $manager->persist($mere);
        }

        // Sauvegarder toutes les entités en base
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PeresFixtures::class,
        ];
    }
}
