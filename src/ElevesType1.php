<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Noms;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Cercles;
use App\Entity\Communes;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\StatutEleves;
use App\Entity\Etablissements;
use App\Entity\LieuNaissances;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Repository\RegionsRepository;
use App\Repository\CerclesRepository;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ElevesType1 extends AbstractType
{
    private const DATE_RANGES = [
        'Petite Section' => [
            'dateNaissance' => ['min' => '-6 years', 'max' => '-4 years'],
            'dateActe' => ['min' => '-6 years', 'max' => 'now']
        ],
        'Moyenne Section' => [
            'dateNaissance' => ['min' => '-7 years', 'max' => '-5 years'],
            'dateActe' => ['min' => '-7 years', 'max' => 'now']
        ],
        // Ajouter les autres niveaux selon le même modèle
    ];

    public function __construct(
        private RegionsRepository $regionsRepository,
        private CerclesRepository $cerclesRepository,
        private CommunesRepository $communesRepository,
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, $this->getImageConfig())
            ->add('document', FileType::class, $this->getDocumentConfig())
            ->add('region', EntityType::class, $this->getRegionConfig())
            ->add('niveau', EntityType::class, $this->getNiveauConfig())
            ->add('sexe', ChoiceType::class, $this->getSexeConfig())
            ->add('dateNaissance', DateType::class, $this->getDateConfig('dateNaissance'))
            ->add('numActe', TextType::class, $this->getNumActeConfig())
            ->add('dateActe', DateType::class, $this->getDateConfig('dateActe'))
            ->add('statutFinance', ChoiceType::class, $this->getStatutFinanceConfig())
            ->add('nom', EntityType::class, $this->getNomConfig())
            ->add('prenom', EntityType::class, $this->getPrenomConfig())
            ->add('isHandicap', CheckboxType::class, [
                'label' => 'Handicapé',
                'required' => false,
            ])
            ->add('natureHandicape', TextType::class, [
                'attr' => ['placeholder' => "Nature du handicap"],
                'required' => false,
            ]);

        $this->addDynamicFields($builder);
    }

    private function addDynamicFields(FormBuilderInterface $builder): void
    {
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            fn(FormEvent $event) => $this->addCerclesField($event->getForm()->getParent(), $event->getForm()->getData())
        );

        $builder->get('niveau')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm()->getParent();
                $niveau = $event->getForm()->getData();
                $this->updateDateConstraints($form, $niveau);
                $this->addClassesField($form, $niveau);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if ($data) {
                    if ($lieuNaissance = $data->getLieuNaissance()) {
                        $commune = $lieuNaissance->getCommune();
                        $cercle = $commune->getCercle();
                        $region = $cercle->getRegion();

                        $this->addCerclesField($form, $region);
                        $this->addCommunesField($form, $cercle);
                        $this->addLieuNaissanceField($form, $commune);

                        $form->get('region')->setData($region);
                        $form->get('cercle')->setData($cercle);
                        $form->get('commune')->setData($commune);
                    }

                    if ($classe = $data->getClasse()) {
                        $this->addClassesField($form, $classe->getNiveau());
                    }
                }
            }
        );
    }

    private function addCerclesField(FormInterface $form, ?Regions $region): void
    {
        $form->add('cercle', EntityType::class, [
            'class' => Cercles::class,
            'placeholder' => 'Sélectionnez un cercle',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('c')
                ->where('c.region = :region')
                ->setParameter('region', $region)
                ->orderBy('c.designation', 'ASC'),
            'choice_label' => 'designation',
            'attr' => ['class' => 'select-cercle'],
            'mapped' => false,
            'constraints' => [new NotBlank()]
        ]);
    }

    private function addCommunesField(FormInterface $form, ?Cercles $cercle): void
    {
        $form->add('commune', EntityType::class, [
            'class' => Communes::class,
            'placeholder' => 'Sélectionnez une commune',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('c')
                ->where('c.cercle = :cercle')
                ->setParameter('cercle', $cercle)
                ->orderBy('c.designation', 'ASC'),
            'choice_label' => 'designation',
            'attr' => ['class' => 'select-commune'],
            'mapped' => false,
            'constraints' => [new NotBlank()]
        ]);
    }

    private function addLieuNaissanceField(FormInterface $form, ?Communes $commune): void
    {
        $form->add('lieuNaissance', EntityType::class, [
            'class' => LieuNaissances::class,
            'placeholder' => 'Sélectionnez un lieu de naissance',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('l')
                ->where('l.commune = :commune')
                ->setParameter('commune', $commune)
                ->orderBy('l.designation', 'ASC'),
            'choice_label' => 'designation',
            'attr' => ['class' => 'select-lieu']
        ]);
    }

    private function addClassesField(FormInterface $form, ?Niveaux $niveau): void
    {
        $form->add('classe', EntityType::class, [
            'class' => Classes::class,
            'placeholder' => 'Sélectionnez une classe',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('c')
                ->where('c.niveau = :niveau')
                ->setParameter('niveau', $niveau)
                ->orderBy('c.designation', 'ASC'),
            'choice_label' => 'designation',
            'attr' => ['class' => 'select-classe']
        ]);
    }

    private function updateDateConstraints(FormInterface $form, ?Niveaux $niveau): void
    {
        // Vérifiez si $niveau est non nul avant d'obtenir la désignation
        if ($niveau !== null) {
            $designation = $niveau->getDesignation();
        } else {
            $designation = 'default'; // Ou une autre valeur par défaut
        }

        // Vérifiez que la désignation existe bien dans DATE_RANGES
        $dateRange = self::DATE_RANGES[$designation] ?? null;

        if ($dateRange) {
            // Ajoutez le champ de date de naissance avec les bornes min et max
            $form->add('dateNaissance', DateType::class, array_merge(
                $this->getDateConfig('dateNaissance'),
                [
                    'attr' => [
                        'min' => (new \DateTimeImmutable($dateRange['dateNaissance']['min']))->format('Y-m-d'),
                        'max' => (new \DateTimeImmutable($dateRange['dateNaissance']['max']))->format('Y-m-d')
                    ]
                ]
            ));

            // Ajoutez le champ de dateActe avec les bornes min et max
            $form->add('dateActe', DateType::class, array_merge(
                $this->getDateConfig('dateActe'),
                [
                    'attr' => [
                        'min' => (new \DateTimeImmutable($dateRange['dateActe']['min']))->format('Y-m-d'),
                        'max' => (new \DateTimeImmutable($dateRange['dateActe']['max']))->format('Y-m-d')
                    ]
                ]
            ));
        }
    }

    public function validateDateRange($value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();
        $niveau = $form->get('niveau')->getData();
    
        if (!$niveau || !isset(self::DATE_RANGES[$niveau->getDesignation()])) {
            return;
        }
    
        $dateRange = self::DATE_RANGES[$niveau->getDesignation()]['dateNaissance'];
        $minDate = new \DateTime($dateRange['min']);
        $maxDate = new \DateTime($dateRange['max']);
    
        // Vérifiez si la valeur est une instance de DateTime ou DateTimeImmutable
        if ($value instanceof \DateTime) {
            // Si la valeur est un DateTime, convertissez-la en DateTimeImmutable
            $value = \DateTimeImmutable::createFromMutable($value);
        }
    
        // Maintenant, vous pouvez comparer la date
        if ($value < $minDate || $value > $maxDate) {
            $context->buildViolation('La date doit être entre %s et %s')
                ->setParameter('%s', $minDate->format('d/m/Y'))
                ->setParameter('%s', $maxDate->format('d/m/Y'))
                ->addViolation();
        }
    }
    


    private function getImageConfig(): array
    {
        return [
            'label' => 'Photo',
            'required' => false,
            'allow_delete' => true,
            'delete_label' => 'Supprimer',
            'download_uri' => false,
            'constraints' => [
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    'mimeTypesMessage' => 'Format d\'image invalide'
                ])
            ]
        ];
    }

    private function getDocumentConfig(): array
    {
        return [
            'label' => 'Documents (PDF/Word)',
            'mapped' => false,
            'required' => false,
            'multiple' => true,
            'constraints' => [
                new All([
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                        ],
                        'mimeTypesMessage' => 'Formats autorisés : PDF, DOC, DOCX'
                    ])
                ])
            ]
        ];
    }

    private function getRegionConfig(): array
    {
        return [
            'class' => Regions::class,
            'choice_label' => 'designation',
            'placeholder' => 'Sélectionnez une région',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('r')
                ->orderBy('r.designation', 'ASC'),
            'attr' => ['class' => 'select-region'],
            'mapped' => false
        ];
    }

    private function getNiveauConfig(): array
    {
        return [
            'class' => Niveaux::class,
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('n')
                ->orderBy('n.id', 'ASC'),
            'choice_label' => 'designation',
            'label' => 'Niveau',
            'placeholder' => 'Choisir le Niveau',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'select-niveau']
        ];
    }

    private function getSexeConfig(): array
    {
        return [
            'label' => 'Genre',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Masculin' => 'M',
                'Féminin' => 'F'
            ],
            'label_attr' => ['class' => 'radio-inline'],
            'constraints' => [new NotBlank(['message' => 'Le genre est obligatoire'])]
        ];
    }

    private function getDateConfig(string $fieldType): array
    {
        return [
            'widget' => 'single_text', // Champ de type 'single_text' pour gérer les dates de manière simple
            'format' => 'yyyy-MM-dd', // Format explicite pour le champ de date (en PHP, 'Y-m-d')
            'constraints' => [
                new NotBlank(['message' => 'Ce champ est obligatoire']),
                new Callback([$this, 'validateDateRange']) // Validation personnalisée pour la plage de dates
            ],
            'auto_initialize' => false,
        ];
    }

    private function getNumActeConfig(): array
    {
        return [
            'label' => 'Numéro d\'extrait de naissance',
            'attr' => [
                'placeholder' => 'Ex: 2023B12345',
                'pattern' => '^[A-Za-z]+[-.]?[0-9]+[A-Za-z]*$',
                'title' => 'Format attendu : Lettres suivies de chiffres',
                'class' => 'form-control-num-acte'
            ],
            'constraints' => [
                new NotBlank(['message' => 'Le numéro d\'extrait est obligatoire']),
                new Regex([
                    'pattern' => '/^[A-Za-z]+[-.]?[0-9]+[A-Za-z]*$/',
                    'message' => 'Format invalide (ex: AB123456)'
                ])
            ],
            'help' => 'Format attendu : 2-4 lettres suivies de 6-12 chiffres',
            'error_bubbling' => false,
            'required' => true
        ];
    }

    private function getStatutFinanceConfig(): array
    {
        return [
            'label' => 'Statut financier',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Privé' => 'privé',
                'Boursier' => 'boursier',
                'Exonéré' => 'exonéré'
            ],
            'label_attr' => ['class' => 'radio-inline font-weight-bold'],
            'constraints' => [new NotBlank(['message' => 'Veuillez sélectionner un statut financier'])],
            'empty_data' => 'privé',
            'data' => 'privé',
            'help' => 'Statut administratif officiel de l\'élève',
            'help_attr' => ['class' => 'text-muted small']
        ];
    }

    private function getNomConfig(): array
    {
        return [
            'label' => 'Nom de famille',
            'class' => Noms::class,
            'placeholder' => 'Sélectionnez un nom',
            'choice_label' => 'designation',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('n')
                ->where('n.designation IS NOT NULL')
                ->andWhere('n.designation != :empty')
                ->setParameter('empty', '')
                ->orderBy('n.designation', 'ASC'),
            'attr' => [
                'class' => 'select-nomfamille',
                'data-autocomplete' => 'true',
                'autocomplete' => 'family-name'
            ],
            'constraints' => [new NotBlank(['message' => 'Le nom de famille est obligatoire'])],
            'error_bubbling' => false,
            'required' => true,
            'help' => 'Nom officiel tel que sur l\'extrait de naissance'
        ];
    }

    private function getPrenomConfig(): array
    {
        return [
            'label' => 'Prénom(s)',
            'class' => Prenoms::class,
            'placeholder' => 'Sélectionnez un prénom',
            'choice_label' => 'designation',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('p')
                ->where('p.designation IS NOT NULL')
                ->andWhere('p.designation != :empty')
                ->setParameter('empty', '')
                ->orderBy('p.designation', 'ASC'),
            'attr' => [
                'class' => 'select-prenom',
                'data-autocomplete' => 'true',
                'autocomplete' => 'given-name'
            ],
            'constraints' => [new NotBlank(['message' => 'Le prénom est obligatoire'])],
            'error_bubbling' => false,
            'required' => true,
            'help' => 'Prénoms complets selon l\'état civil'
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'eleves_form',
        ]);
    }
}
