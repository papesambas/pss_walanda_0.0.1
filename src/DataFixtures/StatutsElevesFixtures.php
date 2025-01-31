<?php

namespace App\DataFixtures;

use App\Entity\StatutEleves;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StatutsElevesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Statuts des élèves
        $statuts = [
            '1ère Inscription', 'Passant', 'Redoublant', 'Transfert Arrivé', 'Transfert Départ', 'Abandon', 'Exclus',
            'Passe au D.E.F.', 'Passe au BAC'
        ];

        foreach ($statuts as $statut) {
            $statutEntity = new StatutEleves();
            $statutEntity->setDesignation($statut);
            $manager->persist($statutEntity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TelephonesFixtures::class,
        ];
    }

}
