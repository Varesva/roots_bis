<?php
// src/Form/FileUploadType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FileUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Ajouter une pièce jointe ?',
                'mapped' => false, // Tell that there is no Entity to link - est dissocier de la base de données
                'required' => false,
                'help' => 'PNG, JPEG WEBP, PDF, texte (.doc, .odt)',
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

                            'mimeTypesMessage' => "Le format {{ type }} de ce fichier est invalide. Les types autorisés sont : {{ types }}",

                            'maxSize' =>
                        10485760,
                            // 'maxSizeMessage' => 'Le fichier est trop volumineux ( {{ size }} {{ suffix }})',

                        'uploadIniSizeErrorMessage' => 'Le fichier est trop volumineux. Taille maximale : {{ limit }} {{ suffix }}',

                        'uploadFormSizeErrorMessage' => 'Le fichier est trop volumineux.',

                        'uploadErrorMessage' => 'Ce fichier ne peut pas être téléchargé (taille trop importante, format invalide...).',

                        'uploadExtensionErrorMessage' => 'Ce fichier ne peut pas être téléchargé (taille trop importante, format invalide...).',                                              
                        ]
                    )
                ],
            ]);

            // ->add('send', SubmitType::class); 
            // We could have added it in the view, as stated in the framework recommendations
    }
}
