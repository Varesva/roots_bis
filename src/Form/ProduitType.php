<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre') 
            ->add('image', FileType::class, [
                'label' => 'Image du produit :',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // 'multiple' => true
            ])
            ->add('prix')
            ->add('giftcard_valeur')
            ->add('livre_auteur')
            ->add('livre_edition')
            ->add('livre_resume')
            ->add('categ_type_cuisine')
            ->add('categ_nutrition')
            ->add('categ_produit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
