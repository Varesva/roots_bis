<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                    'maxLength' => 80,
                    'minLength' => 5,               
                ]
            ])

            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Jane',
                    'class' => 'form-control',
                    'maxLength' => 30,
                    'minLength' => 2,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^([a-zA-Z -éà¨'œ][^0-9!?_;,:\$€£&~#%*{§(\[.¤}@)\]°]*)$/",
                        'message' => 'Veuillez uniquement utiliser des caractères alphabétiques svp.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom svp',
                    ]),
                ]
            ])

            ->add('nom', TextType::class, [

                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'form-control',
                    'maxLength' => 50,
                    'minLength' => 2,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^([a-zA-Z -éà¨'œ][^0-9!?_;,:\$€£&~#%*{§(\[.¤}@)\]°]*)$/",
                        'message' => 'Veuillez uniquement utiliser des caractères alphabétiques svp.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom svp',
                    ]),
                ]

            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les <a href="/conditions-generales-de-vente">
						<u>Conditions générales</u></a>',
                'label_html' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions pour vous inscrire',
                    ]),
                ],
            ])
            
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'help' => 'Au moins 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial',

                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',
                    'placeholder' => '8 caractères minimum'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide. Veuillez entrer un mot de passe svp',
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
