<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 12,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                        // Assure que le mot de passe n'est pas compromis
                        new NotCompromisedPassword(),
                        // Ajout de la contrainte de présence d'une lettre majuscule
                        new Regex([
                            'pattern' => '/[A-Z]/',
                            'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule.',
                        ]),
                        // Ajout de la contrainte de présence d'un chiffre
                        new Regex([
                            'pattern' => '/[0-9]/',
                            'message' => 'Votre mot de passe doit contenir au moins un chiffre.',
                        ]),
                        // Ajout de la contrainte de présence d'un caractère spécial
                        new Regex([
                            'pattern' => '/[\W_]/', // Caractères non alphanumériques
                            'message' => 'Votre mot de passe doit contenir au moins un caractère spécial.',
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Entrez votre nouveau mot de passe',
                    ],
                ],
                'second_options' => [
                    'label' => 'Répétez le mot de passe',
                    'attr' => [
                        'placeholder' => 'Répétez votre nouveau mot de passe',
                    ],
                ],
                'invalid_message' => 'Les deux champs de mot de passe doivent correspondre.',
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
