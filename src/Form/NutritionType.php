<?php

namespace App\Form;

use App\Entity\Nutrition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NutritionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('regime', TextType::class, [
                'label' => 'Régime alimentaire*',
                'attr' => [
                    'maxLength' => 90,
                ]
            ])

            ->add('definition', TextareaType::class, [
                'label' => 'Définition*',
                'attr' => [
                    'placeholder' => 'Definition & description du régime alimentaire',
                    'rows' => '3',
                    'maxLength' => 200,
                ]
            ])

            ->add('image', FileType::class, [
                'label' => 'Image du régime alimentaire',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nutrition::class,
        ]);
    }
}
