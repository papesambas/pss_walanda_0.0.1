<?php

namespace App\Form;

use App\Entity\Departs;
use App\Entity\eleves;
use App\Entity\Etablissements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motif')
            ->add('ecoleDestination')
            ->add('ecoleDepart', EntityType::class, [
                'class' => Etablissements::class,
                'choice_label' => 'id',
            ])
            ->add('eleve', EntityType::class, [
                'class' => eleves::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departs::class,
        ]);
    }
}
