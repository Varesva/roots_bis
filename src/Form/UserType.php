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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email*',
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'class' => 'form-control',
                    'autocomplete' => 'email',
                    'maxLength' => 80,
                    'minLength' => 5,
                ]
            ])

            ->add(
                'roles',
                null,
                [
                    'label' => 'Rôle attribué*',
                ]
                // , ChoiceType::class, [
                //     'choices' => [
                //         'ROLE_USER' => ,
                //         // 'ROLE_ADMIN' => ['ROLE_ADMIN'],
                //     ],
                //     'multiple' => true,
                //     'expanded' => true,
                // ]
            )

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe*',
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
                'label' => 'Nom*',
                'attr' => [
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
                'label' => 'Prénom*',
                'attr' => [
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
                'required' => false,
                'label' => 'N° de téléphone',
                'attr' => [
                    'label' => 'Complément d\'adresse',
                    'maxLength' => 20,
                    'minLength' => 9,
                ]
            ])

            ->add('num', IntegerType::class, [
                'label' => 'Numéro de rue',
                'required' => false,
            ])

            ->add('rue', TextType::class, [
                'label' => 'Nom de rue',
                'required' => false,
                'attr' => [
                    'maxLength' => 100,
                ]
            ])

            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxLength' => 100,
                ]
            ])
            ->add('cp', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
                'attr' => [
                    'maxLength' => 20,
                ]
            ])

            ->add('pays', TextType::class, [
                'required' => false,
                'empty_data' => 'France',
                'attr' => [
                    'value' => 'France',
                    'maxLength' => 100,
                ]
            ])

            ->add('complement_adresse', TextareaType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Informations complémentaires concernant votre adresse',
                    'rows' => '3',
                    'maxLength' => 180,
                ]
            ])

            ->add('isVerified', null, [
                'help' => 'Indique si l\'utilisateur a confirmé son email ou non'
            ]);

        // POUR CONVERTIR UN ARRAY EN STRING et inversement
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
