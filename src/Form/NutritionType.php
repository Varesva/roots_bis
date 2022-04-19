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
            ->add('regime')
            ->add('definition')
            ->add('image', FileType::class, [
                'label'=>'Image du régime alimentaire',
                // unmapped means that this field is not associated to any entity property
                'mapped'=> false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required'=>false,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nutrition::class,
        ]);
    }
}
