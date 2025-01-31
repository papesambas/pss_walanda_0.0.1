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

class Scolarites2Fixtures extends Fixture implements DependentFixtureInterface
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
        $niveaux6eme = $this->niveauxRepository->findBy(["designation" => '6ème Année']);

        // Définir les règles pour les désignations
        $designationRules7eme = [
            '7ème Année' => [1, 2, 3],
        ];
        // Définir les règles pour les désignations
        $designationRules8eme = [
            '8ème Année' => [2, 3, 4, 5],
        ];
        // Définir les règles pour les désignations
        $designationRules9eme = [
            '9ème Année' => [3, 4, 5, 6],
        ];

        foreach ($niveaux6eme as $niveau6eme) {
            $scolarites1 = $this->scolarites1Repository->findByNiveau($niveau6eme);
            foreach ($scolarites1 as $scolarite1) {
                $scolarite1Design = (int) $scolarite1->getDesignation();
                if ($scolarite1Design === 6) {
                    foreach ($niveaux as $niveau) {
                        $designation = $niveau->getDesignation();

                        if (array_key_exists($designation, $designationRules7eme)) {
                            foreach ($designationRules7eme[$designation] as $value) {
                                $scolarite2 = new Scolarites2();
                                $scolarite2->setDesignation($value);
                                $scolarite2->setNiveau($niveau);
                                $scolarite2->setScolarite1($scolarite1);

                                $this->CreateRedoublementFor7eme($value, $scolarite1, $scolarite2, $manager);

                                // Persister chaque objet
                                $manager->persist($scolarite2);
                            }
                        }

                        if (array_key_exists($designation, $designationRules8eme)) {
                            foreach ($designationRules8eme[$designation] as $value) {
                                $scolarite2 = new Scolarites2();
                                $scolarite2->setDesignation($value);
                                $scolarite2->setNiveau($niveau);
                                $scolarite2->setScolarite1($scolarite1);

                                $this->CreateRedoublementFor8eme($value, $scolarite1, $scolarite2, $manager);


                                // Persister chaque objet
                                $manager->persist($scolarite2);
                            }
                        }
                        //9ème Année
                        if (array_key_exists($designation, $designationRules9eme)) {
                            foreach ($designationRules9eme[$designation] as $value) {
                                $scolarite2 = new Scolarites2();
                                $scolarite2->setDesignation($value);
                                $scolarite2->setNiveau($niveau);
                                $scolarite2->setScolarite1($scolarite1);

                                $this->CreateRedoublementFor9eme($value, $scolarite1, $scolarite2, $manager);

                                // Persister chaque objet
                                $manager->persist($scolarite2);
                            }
                        }
                    }
                } elseif ($scolarite1Design === 7) {
                    $redoublements1 = $scolarite1->getRedoublements1s();
                    foreach ($redoublements1 as $redoublement1) {
                        foreach ($niveaux as $niveau) {
                            $designation = $niveau->getDesignation();

                            if (array_key_exists($designation, $designationRules7eme)) {
                                foreach ($designationRules7eme[$designation] as $value) {
                                    $scolarite2 = new Scolarites2();
                                    $scolarite2->setDesignation($value);
                                    $scolarite2->setNiveau($niveau);
                                    $scolarite2->setScolarite1($scolarite1);

                                    $this->CreateRedoublementFor7eme_1Redoub($value, $scolarite1, $scolarite2, $redoublement1, $manager);

                                    // Persister chaque objet
                                    $manager->persist($scolarite2);
                                }
                            }

                            if (array_key_exists($designation, $designationRules8eme)) {
                                foreach ($designationRules8eme[$designation] as $value) {
                                    $scolarite2 = new Scolarites2();
                                    $scolarite2->setDesignation($value);
                                    $scolarite2->setNiveau($niveau);
                                    $scolarite2->setScolarite1($scolarite1);

                                    $this->CreateRedoublementFor8eme_1Redoub($value, $scolarite1, $scolarite2, $redoublement1, $manager);


                                    // Persister chaque objet
                                    $manager->persist($scolarite2);
                                }
                            }
                            //9ème Année
                            if (array_key_exists($designation, $designationRules9eme)) {
                                foreach ($designationRules9eme[$designation] as $value) {
                                    $scolarite2 = new Scolarites2();
                                    $scolarite2->setDesignation($value);
                                    $scolarite2->setNiveau($niveau);
                                    $scolarite2->setScolarite1($scolarite1);

                                    $this->CreateRedoublementFor9eme_1Redoub($value, $scolarite1, $scolarite2, $redoublement1, $manager);

                                    // Persister chaque objet
                                    $manager->persist($scolarite2);
                                }
                            }
                        }
                    }
                } elseif ($scolarite1Design === 8) {
                    $redoublements1 = $scolarite1->getRedoublements1s();
                    foreach ($redoublements1 as $redoublement1) {
                        $redoublements2 = $redoublement1->getRedoublements2s();
                        foreach ($redoublements2 as $redoublement2) {
                            foreach ($niveaux as $niveau) {
                                $designation = $niveau->getDesignation();

                                if (array_key_exists($designation, $designationRules7eme)) {
                                    foreach ($designationRules7eme[$designation] as $value) {
                                        $scolarite2 = new Scolarites2();
                                        $scolarite2->setDesignation($value);
                                        $scolarite2->setNiveau($niveau);
                                        $scolarite2->setScolarite1($scolarite1);

                                        $this->CreateRedoublementFor7eme_2Redoub($value, $scolarite1, $scolarite2, $redoublement2, $manager);

                                        // Persister chaque objet
                                        $manager->persist($scolarite2);
                                    }
                                }

                                if (array_key_exists($designation, $designationRules8eme)) {
                                    foreach ($designationRules8eme[$designation] as $value) {
                                        $scolarite2 = new Scolarites2();
                                        $scolarite2->setDesignation($value);
                                        $scolarite2->setNiveau($niveau);
                                        $scolarite2->setScolarite1($scolarite1);

                                        $this->CreateRedoublementFor8eme_2Redoub($value, $scolarite1, $scolarite2, $redoublement2, $manager);


                                        // Persister chaque objet
                                        $manager->persist($scolarite2);
                                    }
                                }
                                //9ème Année
                                if (array_key_exists($designation, $designationRules9eme)) {
                                    foreach ($designationRules9eme[$designation] as $value) {
                                        $scolarite2 = new Scolarites2();
                                        $scolarite2->setDesignation($value);
                                        $scolarite2->setNiveau($niveau);
                                        $scolarite2->setScolarite1($scolarite1);

                                        $this->CreateRedoublementFor9eme_2Redoub($value, $scolarite1, $scolarite2, $redoublement2, $manager);

                                        // Persister chaque objet
                                        $manager->persist($scolarite2);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        // Sauvegarder en base
        $manager->flush();
    }


    private function CreateRedoublementFor7eme($value, $scolarite1, $scolarite2, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 2) {
            $redoublement1 = new Redoublements1();
            $redoublement1->setDesignation('7ème Année');
            $redoublement1->setScolarite1($scolarite1);
            $redoublement1->setScolarite2($scolarite2);
            $manager->persist($redoublement1);
        } else {
            $redoublement1 = new Redoublements1();
            $redoublement1->setDesignation('7ème Année');
            $redoublement1->setScolarite1($scolarite1);
            $redoublement1->setScolarite2($scolarite2);
            $manager->persist($redoublement1);
            $redoublement2 = new Redoublements2();
            $redoublement2->setDesignation('7ème Année');
            $redoublement2->setScolarite1($scolarite1);
            $redoublement2->setScolarite2($scolarite2);
            $redoublement2->setRedoublement1($redoublement1);
            $manager->persist($redoublement2);
        }
    }

    private function CreateRedoublementFor8eme($value, $scolarite1, $scolarite2, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 3) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('8ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 4) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('8ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 5) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('8ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        }
    }

    private function CreateRedoublementFor9eme($value, $scolarite1, $scolarite2, $manager)
    {

        // Instructions spécifiques pour valeur == 2
        if ($value == 4) {
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('8ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                } else {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('9ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                }
            }
        } elseif ($value == 5) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('8ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 3) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('9ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 6) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } elseif ($i == 1) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('7ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } elseif ($i == 2) {
                    $redoublement1 = new Redoublements1();
                    $redoublement1->setDesignation('8ème Année');
                    $redoublement1->setScolarite1($scolarite1);
                    $redoublement1->setScolarite2($scolarite2);
                    $manager->persist($redoublement1);
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        }
    }

    private function CreateRedoublementFor7eme_1Redoub($value, $scolarite1, $scolarite2, $redoublement1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 2) {
            $redoublement2 = new Redoublements2();
            $redoublement2->setDesignation('7ème Année');
            $redoublement2->setScolarite1($scolarite1);
            $redoublement2->setScolarite2($scolarite2);
            $redoublement2->setRedoublement1($redoublement1);
            $manager->persist($redoublement2);
        } else {
            $redoublement2 = new Redoublements2();
            $redoublement2->setDesignation('7ème Année');
            $redoublement2->setScolarite1($scolarite1);
            $redoublement2->setScolarite2($scolarite2);
            $redoublement2->setRedoublement1($redoublement1);
            $manager->persist($redoublement2);
            $redoublement3 = new Redoublements3();
            $redoublement3->setDesignation('7ème Année');
            $redoublement3->setScolarite1($scolarite1);
            $redoublement3->setScolarite2($scolarite2);
            $redoublement3->setRedoublement2($redoublement2);
            $manager->persist($redoublement3);
        }
    }

    private function CreateRedoublementFor8eme_1Redoub($value, $scolarite1, $scolarite2, $redoublement1, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 3) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('7ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 4) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('7ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('8ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } else {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('8ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        }
    }

    private function CreateRedoublementFor9eme_1Redoub($value, $scolarite1, $scolarite2,$redoublement1, $manager)
    {

        // Instructions spécifiques pour valeur == 2
        if ($value == 4) {
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('7ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } elseif ($i == 1) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                } else {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                }
            }
        } elseif ($value == 5) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 0) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('7ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('8ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } elseif ($i == 1) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('7ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } elseif ($i == 2) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('8ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                } elseif ($i == 3) {
                    $redoublement2 = new Redoublements2();
                    $redoublement2->setDesignation('9ème Année');
                    $redoublement2->setScolarite1($scolarite1);
                    $redoublement2->setScolarite2($scolarite2);
                    $redoublement2->setRedoublement1($redoublement1);
                    $manager->persist($redoublement2);
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        } 
    }

    private function CreateRedoublementFor7eme_2Redoub($value, $scolarite1, $scolarite2, $redoublement2, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 2) {
            $redoublement3 = new Redoublements3();
            $redoublement3->setDesignation('7ème Année');
            $redoublement3->setScolarite1($scolarite1);
            $redoublement3->setScolarite2($scolarite2);
            $redoublement3->setRedoublement2($redoublement2);
            $manager->persist($redoublement3);
        }
    }

    private function CreateRedoublementFor8eme_2Redoub($value, $scolarite1, $scolarite2, $redoublement2, $manager)
    {
        // Instructions spécifiques pour valeur == 2
        if ($value == 3) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('8ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        }
    }

    private function CreateRedoublementFor9eme_2Redoub($value, $scolarite1, $scolarite2,$redoublement2, $manager)
    {

        // Instructions spécifiques pour valeur == 2
        if ($value == 4) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $redoublement3 = new Redoublements3();
                    $redoublement3->setDesignation('9ème Année');
                    $redoublement3->setScolarite1($scolarite1);
                    $redoublement3->setScolarite2($scolarite2);
                    $redoublement3->setRedoublement2($redoublement2);
                    $manager->persist($redoublement3);
                }
            }
        } 
    }




    public function getDependencies(): array
    {
        return [
            Scolarites1Fixtures::class,
        ];
    }
}
