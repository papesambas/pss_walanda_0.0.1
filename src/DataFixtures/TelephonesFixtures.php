<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Telephones;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TelephonesFixtures extends Fixture implements DependentFixtureInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    public function load(ObjectManager $manager): void
    {
        // Numéros de téléphone uniques
        $faker = Factory::create();
        $usedNumbers = [];
        for ($i = 0; $i < 100; $i++) {
            $telephone = new Telephones();
            do {
                $malitel = '(' . $faker->numberBetween(100, 999) . ') ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99);
            } while (in_array($malitel, $usedNumbers));

            do {
                $orange = '(' . $faker->numberBetween(100, 999) . ') ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99) . ' ' .
                    $faker->numberBetween(10, 99);
            } while (in_array($orange, $usedNumbers));

            $telephone->setMalitel($malitel);
            $telephone->setOrange($orange);

            $errors = $this->validator->validate($telephone);
            if (count($errors) > 0) {
                $validationErrors[] = $errors;
            } else {
                $manager->persist($telephone);
                $usedNumbers[] = $malitel;
                $usedNumbers[] = $orange;
                $this->addReference('telephone_' . $i, $telephone);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NinasFixtures::class,
        ];
    }

}
