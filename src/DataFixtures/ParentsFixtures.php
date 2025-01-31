<?php

namespace App\DataFixtures;

use App\Entity\Meres;
use App\Entity\Peres;
use App\Entity\Parents;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ParentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les pères et mères
        $peres = $manager->getRepository(Peres::class)->findAll();
        $meres = $manager->getRepository(Meres::class)->findAll();

        // Vérification des références pour éviter les erreurs
        if (empty($peres) || empty($meres)) {
            return; // Évite une erreur si les parents ne sont pas chargés
        }

        // Créer 30 familles recomposées
        for ($i = 0; $i < 30; $i++) {
            // Sélection aléatoire d'un père et d'une mère
            $pere = $peres[array_rand($peres)];
            $mere = $meres[array_rand($meres)];

            // Vérifier si la combinaison père/mère existe déjà dans la base de données
            $parentExist = $manager->getRepository(Parents::class)->findOneBy([
                'pere' => $pere,
                'mere' => $mere,
            ]);

            if (!$parentExist) {
                $parent = new Parents();
                $parent->setPere($pere);
                $parent->setMere($mere);

                // Persist l'entité Parents uniquement si elle n'existe pas
                $manager->persist($parent);
            }
        }

        // Enregistrer toutes les entités persistées
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MeresFixtures::class, // Cette fixture dépend de MeresFixtures
        ];
    }
}
