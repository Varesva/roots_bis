<?php

namespace App\Form;

use App\Form\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'help' => 'Nous vous recontacterons sur cet email',
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'maxLength' => 50,
                    'minLength' => 3,
                ]
            ])

            ->add('identity', TextType::class, [
                'help' => 'Prénom NOM',
                'attr' => [
                    'placeholder' => 'Jane DOE',
                    'maxLength' => 80,
                    'minLength' => 3,
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
                    'rows' => '4',
                    'minLength' => 15,
                    'maxLength' => 2000,
                ]
            ])

            ->add(
                'attachement',
                FileType::class,
                [
                    'label' => 'Ajouter une pièce jointe ?',
                    // 'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'help' => ' (Formats acceptés : png, jpeg, webp, pdf, doc, odt)',
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
                                    'application / vnd . oasis . opendocument . text'
                                ],
                                'mimeTypesMessage' => "Le format {{ type }} de ce fichier est invalide.",

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
                'label' => 'Envoyer',
                'row_attr' => [
                    'class' => 'col-12 text-center mb-3',
                ],
                'attr' => [
                    'class' => 'btn btn-lg btn-success ',
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
