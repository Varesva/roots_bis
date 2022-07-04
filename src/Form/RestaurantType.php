<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom*',
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

            ->add('image', FileType::class, [
                'label' => 'Image du restaurant',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // 'multiple' => true,
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description*',
                'attr' => [
                    'placeholder' => 'Fiche descriptive du restaurant',
                    'rows' => '3',
                    'maxLength' => 1000,
                ]
            ])

            ->add('num_rue', IntegerType::class, [
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

            ->add('code_postal', TextType::class, [
                'label' => 'Code Postal*',
                'attr' => [
                    'maxLength' => 20,
                ]
            ])

            ->add('ville', TextType::class, [
                'label' => 'Ville*',
                'attr' => [
                    'maxLength' => 100,
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

            ->add('email', EmailType::class, [
                'help' => 'Email de contact principal',
                'required' => false,
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                    'maxLength' => 50,
                    'minLength' => 5,
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

            ->add('website', UrlType::class, [
                'required' => false,
            ])

            ->add('specialite')
            ->add('nutrition')
            ->add('categorie');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
