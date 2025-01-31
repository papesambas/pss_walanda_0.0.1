<?php

namespace App\DataFixtures;

use App\Entity\Ninas;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class NinasFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $usedDesignations = []; 

        // Ninas avec numéros uniques
        for ($l = 0; $l < 150; $l++) {
            do {
                $digits = str_pad($faker->numberBetween(0, 99999999999999), 14, '0', STR_PAD_LEFT);
                $letter = chr($faker->numberBetween(65, 90)); 
                $designation = $digits . $letter;
            } while (in_array($designation, $usedDesignations));

            $usedDesignations[] = $designation;
            $ninas = new Ninas();
            $ninas->setDesignation($designation);
            $manager->persist($ninas);
            $this->addReference('nina_' . $l, $ninas);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProfessionsFixtures::class,
        ];
    }

}
