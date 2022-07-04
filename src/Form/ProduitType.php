<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Nom du produit*',
                'attr' => [
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
                'label' => 'Image du produit :',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // 'multiple' => true
            ])

            ->add('prix', MoneyType::class, [
                'html5' => true,
                'label' => 'Prix (€)*'
            ])

            ->add('giftcard_valeur')

            ->add('livre_auteur', TextType::class, [
                'required' => false,
                'label' => 'Nom de l\'auteur',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])

            ->add('livre_edition', TextType::class, [
                'required' => false,
                'label' => 'Nom édition',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])

            ->add('livre_resume', TextareaType::class, [
                'required' => false,
                'label' => 'Description*',
                'attr' => [
                    'placeholder' => 'Fiche descriptive du restaurant',
                    'rows' => '3',
                    'maxLength' => 500,
                ]
            ])

            ->add('categ_type_cuisine')
            ->add('categ_nutrition')
            ->add('categ_produit');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
