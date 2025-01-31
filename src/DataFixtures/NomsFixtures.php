<?php

namespace App\DataFixtures;

use App\Entity\Noms;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NomsFixtures extends Fixture implements DependentFixtureInterface
{
    public const NOM_REFERENCE = 'nomEntity';

    public function load(ObjectManager $manager): void
    {
        // Noms de famille
        $nomsDeFamilleMali = [
            'Bamogo', 'Diakité', 'Fofana', 'Keita', 'Touré', 'Sissoko', 'Cissé', 'Traoré',
            'Coulibaly', 'Diallo', 'Sow', 'Sidibé', 'N’Diaye', 'Sanogo', 'Diarra', 'Bamba',
            'Maïga', 'Sako', 'Kouyaté', 'Konaté', 'Sékou', 'Dembélé', 'Doumbia', 'Kaba',
            'Ba', 'Makan', 'Tiemogo', 'Fily', 'Aminata', 'Seydou', 'Awa', 'Yattara', 'Sagnon',
            'Kouadio', 'Soro', 'Abdoulaye', 'Ali', 'Samaké', 'Aissatou', 'Cheick', 'Baye',
            'Tanga', 'Diop', 'Koné', 'Bany', 'Sidi', 'Kante', 'Bara', 'Maha', 'Fouad', 'Oumarou',
            'Amadou', 'Karamoko', 'Demba',
        ];

        foreach ($nomsDeFamilleMali as $nom) {
            $nomEntity = new Noms();
            $nomEntity->setDesignation($nom);
            $manager->persist($nomEntity);
            $this->setReference(self::NOM_REFERENCE,$nomEntity); // Utiliser un nom unique
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LieuNaissancesFixtures::class,
        ];
    }
}
