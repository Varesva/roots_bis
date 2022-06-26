<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $recaptcha_public_key = '6LfN8pIgAAAAAJza8SesGMU3l7GRByC3Vm0WOxzs';

        $builder
            ->add('email', EmailType::class, [
                'help' => 'Email pour vous recontacter',
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                    'maxLength' => 50,
                    'minLength' => 5,
                ]
            ])

            ->add('identity', TextType::class, [
                'help' => 'Prénom NOM',
                'attr' => [
                    'placeholder' => 'Jane DOE',
                    'class' => 'form-control',
                    'maxLength' => 80,
                    'minLength' => 5,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-Z -éà¨'œ]*$/",
                        'message' => 'Veuillez uniquement utiliser des caractères alphabétiques svp.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom et nom de famille svp',
                    ]),
                ]
            ])

            ->add('subject', TextType::class, [
                'attr' => [
                    'placeholder' => 'L\'objet de votre email',
                    'class' => 'form-control',
                    'maxLength' => 100,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un objet svp',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'L\'objet doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 100,
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Bonjour, je vous contacte car ...',
                    'rows' => '5',
                    'minLength' => 15,
                    'maxLength' => 2000,
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'row_attr' => [
                    'class' => 'col-12 text-center mb-3',
                ],
                'attr' => [
                    'class' => 'btn btn-lg btn-success ',
                    // 'onclick' => 'resetForm()'
                    // g-recaptcha
                    // 'data-size' => 'invisible',
                    // 'data-sitekey' => $recaptcha_public_key,
                    // 'data-callback' => 'onSubmit',
                    // 'data-action' => 'submit',
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
