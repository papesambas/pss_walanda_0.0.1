<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Eleves;
use App\Entity\Etablissements;
use App\Entity\EtablissementsFrequente;
use App\Entity\LieuNaissances;
use App\Entity\Noms;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\StatutEleves;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sexe')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('numActe')
            ->add('dateActe', null, [
                'widget' => 'single_text',
            ])
            ->add('dateRecrutement', null, [
                'widget' => 'single_text',
            ])
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('matricule')
            ->add('isAdmin')
            ->add('isAllowed')
            ->add('isActif')
            ->add('isHandicap')
            ->add('natureHandicape')
            ->add('statutFinance')
            ->add('imageName')
            ->add('imageSize')
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('slug')
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
            ->add('statutEleve', EntityType::class, [
                'class' => StatutEleves::class,
                'choice_label' => 'id',
            ])
            ->add('scolarite1', EntityType::class, [
                'class' => Scolarites1::class,
                'choice_label' => 'id',
            ])
            ->add('scolarite2', EntityType::class, [
                'class' => Scolarites2::class,
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
