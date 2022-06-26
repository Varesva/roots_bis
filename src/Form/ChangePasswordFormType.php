<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'help' => 'Au moins 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => '8 caractères minimum',
                    ],
                    'row_attr' => [
                        'class' => 'mb-4',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe svp',
                        ]),
                        new PasswordStrength(
                            [
                                'minLength' => 8,
                                'tooShortMessage' => 'Votre mot de passe doit faire au moins {{length}} caractères',
                                'minStrength' => 4,
                                'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial',
                            ]
                        ),
                    ],
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'help' => 'Indiquez une deuxième fois votre nouveau mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Réécrivez votre mot de passe',
                    ],
                    'row_attr' => [
                        'class' => 'mb-3',
                    ],

                    'label' => 'Confirmer le mot de passe',
                ],

                'invalid_message' => 'Les deux champs doivent indiquer un mot de passe identique',

                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
