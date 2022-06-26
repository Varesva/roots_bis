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
            ->add('upload_file', FileType::class, [
                'label' => false,
                'mapped' => false, // Tell that there is no Entity to link - est dissocier de la base de données
                'required' => false,
                'help' => 'PNG, JPEG, JPG, WEBP, PDF, EXCEL - 2 Mo maximum',
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
                                'application/excel',
                            ],
                            'mimeTypesMessage' => "Le format {{ type }} de ce fichier est invalide. Les types autorisés sont : {{ types }}",

                            'maxSize' => '2M',
                            'maxSizeMessage' => 'Le fichier est trop volumineux.',
                        ]
                    )
                ],
            ])
            ->add('send', SubmitType::class); // We could have added it in the view, as stated in the framework recommendations
    }
}
