<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Classes;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Etablissements;
use App\Entity\LieuNaissances;
use App\Entity\EtablissementsFrequente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => "Photo d'identité",
                //'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ],
                'allow_delete' => true,
                'delete_label' => 'supprimer',
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'image_uri'         => false,
                'asset_helper' => true,
            ])
            ->add('document', FileType::class, [
                'label' => 'Télécharger Documents (Fichier PDF/Word)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '2048k',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ],
                                'mimeTypesMessage' => 'Format valid valid PDF ou word',
                            ])
                        ]
                    ]),
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'M' => 'Masculin',
                    'F' => 'Féminin'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
            ->add('numActe')
            ->add('dateActe', DateType::class, [
                'label' => "date d'élaboration",
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
            ->add('dateRecrutement', DateType::class, [
                'label' => 'Date de Recrutement',
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
            ->add('dateInscription', DateType::class, [
                'label' => "date d'inscription",
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
            ->add('matricule')
            ->add('isAdmin')
            ->add('isAllowed')
            ->add('isActif')
            ->add('isHandicap')
            ->add('natureHandicape')
            ->add('statutFinance')
            //->add('imageName')
            //->add('imageSize')
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'choice_label' => 'id',
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'id',
            ])
            ->add('lieuNaissance', EntityType::class, [
                'class' => LieuNaissances::class,
                'choice_label' => 'id',
            ])
            ->add('etablissement', EntityType::class, [
                'class' => Etablissements::class,
                'choice_label' => 'id',
            ])
            ->add('ecoleInscription', EntityType::class, [
                'class' => EtablissementsFrequente::class,
                'choice_label' => 'id',
            ])
            ->add('ecoleAnDernier', EntityType::class, [
                'class' => EtablissementsFrequente::class,
                'choice_label' => 'id',
            ])
            ->add('classe', EntityType::class, [
                'class' => Classes::class,
                'choice_label' => 'id',
            ])
            ->add('parent', EntityType::class, [
                'class' => Parents::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('createdBy', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('updatedBy', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
