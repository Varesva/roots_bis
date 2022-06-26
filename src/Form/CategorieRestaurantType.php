<?php

namespace App\Form;

use App\Entity\CategorieRestaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CategorieRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_cuisine', TextType::class, [
                'attr' => [
                    'maxLength' => 50,
                'maxLenghtMessage' => 'Votre message ne doit pas excéder {{ limit }} caractères.'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de la catégorie',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieRestaurant::class,
        ]);
    }
}
