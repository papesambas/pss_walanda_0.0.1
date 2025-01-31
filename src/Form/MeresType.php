<?php

namespace App\Form;

use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Noms;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\Entity\Telephones;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'choice_label' => 'id',
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'id',
            ])
            ->add('profession', EntityType::class, [
                'class' => Professions::class,
                'choice_label' => 'id',
            ])
            ->add('nina', EntityType::class, [
                'class' => Ninas::class,
                'choice_label' => 'id',
            ])
            ->add('telephone1', EntityType::class, [
                'class' => Telephones::class,
                'choice_label' => 'id',
            ])
            ->add('telephone2', EntityType::class, [
                'class' => Telephones::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meres::class,
        ]);
    }
}
