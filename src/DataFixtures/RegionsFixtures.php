<?php

namespace App\DataFixtures;

use App\Entity\Regions;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RegionsFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $regions = [
            'Bamako', 'Kayes', 'Ségou', 'Koulikoro', 'Mopti', 'Tombouctou', 'Gao', 'Kidal'
        ];

        foreach ($regions as $regionName) {
            $region = new Regions();
            $region->setDesignation($regionName);
            $manager->persist($region);
        }

        $manager->flush();
    }

}
