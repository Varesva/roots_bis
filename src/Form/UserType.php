<?php
// Accès admin - liste crud des utilisateurs
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'class' => 'form-control',
                    'autocomplete' => 'email',
                    'maxLength' => 80,
                    'minLength' => 5,
                ]
            ])

            ->add('roles')

            ->add('password', PasswordType::class, [
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
            ])

            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre nom',
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

            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre prénom',
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

            ->add('telephone', TelType::class, [
                'attr' => [
                    'placeholder' => 'N° à joindre lors de la livraison',
                    'maxLength' => 20,
                    'minLength' => 9,
                ]
            ])

            ->add('num')

            ->add('rue')

            ->add('ville')

            ->add('cp')

            ->add('pays', TextType::class, [
                'required' => false,
                'empty_data' => 'France',
                'attr' => [
                    'value' => 'France',
                ]
            ])

            ->add('isVerified');

        // pour convertir un array en string
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    // transform the array to a string
                    return implode(', ', $rolesAsArray);
                    // return count($rolesAsArray) ? $rolesAsArray[0] : null;
                    // return [$rolesAsArray];
                },
                function ($rolesAsString) {
                    // transform the string back to an array
                    return explode(', ', $rolesAsString);

                    // return [$rolesAsString];
                    // return $rolesAsString;
                }
            ));
        // fin

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
