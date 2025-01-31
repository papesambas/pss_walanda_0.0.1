<?php

namespace App\DataFixtures;

use App\Entity\Niveaux;
use App\Entity\Scolarites1;
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Entity\Scolarites2;
use App\Repository\NiveauxRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\Scolarites1Repository;
use App\Repository\Scolarites2Repository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\Redoublements1Repository;
use App\Repository\Redoublements2Repository;
use App\Repository\Redoublements3Repository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Scolarites1Fixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private NiveauxRepository $niveauxRepository,
        private Scolarites1Repository $scolarites1Repository,
        private Scolarites2Repository $scolarites2Repository,
        private Redoublements1Repository $redoublements1Repository,
        private Redoublements2Repository $redoublements2Repository,
        private Redoublements3Repository $redoublements3Repository
    ) {}
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les niveaux
        $niveaux = $this->niveauxRepository->findAll();
        $niveaux1ère = $this->niveauxRepository->findOneBy(["designation" => '1ère Année']);
        $niveaux2ème = $this->niveauxRepository->findOneBy(["designation" => '2ème Année']);
        $niveaux3ème = $this->niveauxRepository->findOneBy(["designation" => '3ème Année']);
        $niveaux4ème = $this->niveauxRepository->findOneBy(["designation" => '4ème Année']);
        $niveaux5ème = $this->niveauxRepository->findOneBy(["designation" => '5ème Année']);
        $niveaux6ème = $this->niveauxRepository->findOneBy(["designation" => '6ème Année']);

        // Définir les règles pour les désignations
        $designationRules1ere = [
            '1ère Année' => [1, 2, 3],
        ];
        // Définir les règles pour les désignations
        $designationRules2eme = [
            '2ème Année' => [2, 3, 4, 5],
        ];
        // Définir les règles pour les désignations
        $designationRules3eme = [
            '3ème Année' => [3, 4, 5, 6],
        ];
        // Définir les règles pour les désignations
        $designationRules4eme = [
            '4ème Année' => [4, 5, 6, 7],
        ];
        $designationRules5eme = [
            '5ème Année' => [5, 6, 7, 8],
        ];
        $designationRules6eme = [
            '6ème Année' => [6, 7, 8, 9],
        ];

        foreach ($niveaux as $niveau) {
            $designation = $niveau->getDesignation();

            if (array_key_exists($designation, $designationRules1ere)) {
                foreach ($designationRules1ere[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor1ere($value, $scolarite1, $manager);

                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }

            if (array_key_exists($designation, $designationRules2eme)) {
                foreach ($designationRules2eme[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor2eme($value, $scolarite1, $manager);


                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }
            //3ème Année
            if (array_key_exists($designation, $designationRules3eme)) {
                foreach ($designationRules3eme[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor3eme($value, $scolarite1, $manager);

                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }

            //4ème Année
            if (array_key_exists($designation, $designationRules4eme)) {
                foreach ($designationRules4eme[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor4eme($value, $scolarite1, $manager);

                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }

            //5ème Année
            if (array_key_exists($designation, $designationRules5eme)) {
                foreach ($designationRules5eme[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor5eme($value, $scolarite1, $manager);

                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }

            //6ème
            if (array_key_exists($designation, $designationRules6eme)) {
                foreach ($designationRules6eme[$designation] as $value) {
                    $scolarite1 = new Scolarites1();
                    $scolarite1->setDesignation($value);
                    $scolarite1->setNiveau($niveau);

                    $this->CreateRedoublementFor6eme($value, $scolarite1, $manager);

                    // Persister chaque objet
                    $manager->persist($scolarite1);
                }
            }
        }


        // Sauvegarder en base
        $manager->flush();
    }


    private function CreateRedoublementFor1ere($value, $scolarite1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 2) {
            $redoublement1 = new Redoublements1();
            $redoublement1->setDesignation('1ère Année');
            $redoublement1->setScolarite1($scolarite1);
            $manager->persist($redoublement1);
        } else {
            $redoublement1 = new Redoublements1();
            $redoublement1->setDesignation('1ère Année');
            $redoublement1->setScolarite1($scolarite1);
            $manager->persist($redoublement1);
            $redoublement2 = new Redoublements2();
            $redoublement2->setDesignation('1ère Année');
            $redoublement2->setScolarite1($scolarite1);
            $redoublement2->setRedoublement1($redoublement1);
            $manager->persist($redoublement2);
            $manager->persist($redoublement1);
        }
    }

    private function CreateRedoublementFor2eme($value, $scolarite1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 3) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 4) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 5) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('2ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                }
            }
        }
    }

    private function CreateRedoublementFor3eme($value, $scolarite1, $manager)
    {

        // Instructions spécifiques pour valeur == 2
        if ($value == 4) {
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 5) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 6) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('3ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('3ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('3ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                }
            }
        }
    }

    private function CreateRedoublementFor4eme($value, $scolarite1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 5) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 6) {
            for ($i = 0; $i < 6; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 5) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 7) {
            for ($i = 0; $i < 6; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                }
            }
        }
    }

    private function CreateRedoublementFor5eme($value, $scolarite1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 6) {
            for ($i = 0; $i < 5; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('5ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 7) {
            for ($i = 0; $i < 11; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 5) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 6) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 7) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 8) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 9) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('5ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 8) {
            for ($i = 0; $i < 10; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 5) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 6) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 7) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 8) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                }
            }
        }
    }

    private function CreateRedoublementFor6eme($value, $scolarite1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 7) {
            for ($i = 0; $i < 5; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('5ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 8) {
            for ($i = 0; $i < 11; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 5) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 6) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 7) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 8) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 9) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('5ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 9) {
            for ($i = 0; $i < 10; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('2ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('1ère Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 4) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('3ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 5) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 6) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('2ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 7) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } elseif ($i == 8) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('3ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('5ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('5ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('4ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('4ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setRedoublement1($redoublement1);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('4ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                    $manager->persist($redoublement2);
                }
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            EtablissementsFrequenteFixtures::class,
        ];
    }
}
