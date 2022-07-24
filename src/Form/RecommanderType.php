<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecommanderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'help' => 'Nous vous recontacterons sur cet email, si besoin',
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'maxLength' => 50,
                    'minLength' => 3,
                ]
            ])

            ->add('restaurant', TextType::class, [
                'attr' => [
                    'placeholder' => 'Resto recommandé',
                    'maxLength' => 80,
                ], 'constraints' => [
                    new Type([
                        'type' => 'string'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom du restaurant recommandé svp',
                    ]),
                ]
            ])

            ->add('message', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quel est votre coup de cœur ?  (Les plats, le lieu, le personnel, l\'histoire ?...). Dites-nous tout !',
                    'rows' => '3',
                    'maxLength' => 1000,
                ]
            ])

            ->add('attachement', FileType::class, [
                    'label' => 'Ajouter une pièce jointe ?',
                    // 'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'help' => ' (png, jpeg, webp, pdf)',
                    'constraints' => [
                        new File(
                            [
                                'mimeTypes' =>
                                [
                                    'image/jpeg',
                                    'image/jpg',
                                    'image/jp2',
                                    'image/webp',
                                    'image/png',
                                    'application/pdf',
                                    'application / msword',
                                ],
                                'mimeTypesMessage' => "Le format {{ type }} de ce fichier est invalide. Les types autorisés sont : {{ types }}",

                                'maxSize' =>
                                10485760,
                                'maxSizeMessage' => 'Le fichier est trop volumineux ( {{ size }} {{ suffix }})',
                                'uploadIniSizeErrorMessage' => 'Le fichier est trop volumineux. Taille maximale : {{ limit }} {{ suffix }}',
                                'uploadFormSizeErrorMessage' => 'Le fichier est trop volumineux.',
                                'uploadErrorMessage' => 'Ce fichier ne peut pas être téléchargé (taille trop importante, format invalide...).',
                            ]
                        )
                    ],
                ]
            )

            ->add('send', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
