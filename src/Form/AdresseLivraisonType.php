<?php

namespace App\Form;

use App\Entity\AdresseLivraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdresseLivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
            'label' => 'Nom*',
                'attr' => [
                    'placeholder' => 'Nom du destinataire',
                    'class' => 'form-control',
                    'maxLength' => 30,
                    'minLength' => 2,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^([a-zA-Z -éà¨'œ][^0-9!?_;,:\$€£&~#%*{§(\[.¤}@)\]°]*)$/",
                        'message' => 'Veuillez uniquement utiliser des caractères alphabétiques svp.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom svp',
                    ]),
                ]
            ])

            ->add('prenom', TextType::class, [
                'placeholder' => 'Prénom du destinataire',
                'label' => 'Prénom*',
                'attr' => [
                    'class' => 'form-control',
                    'maxLength' => 30,
                    'minLength' => 2,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^([a-zA-Z -éà¨'œ][^0-9!?_;,:\$€£&~#%*{§(\[.¤}@)\]°]*)$/",
                        'message' => 'Veuillez uniquement utiliser des caractères alphabétiques svp.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom svp',
                    ]),
                ]
            ])

            ->add('telephone', TelType::class, [
                'placeholder' => 'N° à joindre lors de la livraison',
                'required' => false,
                'label' => 'N° de téléphone',
                'attr' => [
                    'label' => 'Complément d\'adresse',
                    'maxLength' => 20,
                    'minLength' => 9,
                ]
            ])

            ->add('num', IntegerType::class, [
                'label' => 'Numéro de rue*',
            ])

            ->add('rue', TextType::class, [
                'label' => 'Nom de rue*',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])

            ->add('cp', TextType::class, [
                'label' => 'Code postal*',
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
            'label' => 'Pays*',
                'empty_data' => 'France',
                'attr' => [
                    'value' => 'France',
                    'maxLength' => 100,
                ]
            ])

            ->add('complement_adresse', TextareaType::class, [
                'required' => false,
                'label' => 'Complément d\'adresse',
                'attr' => [
                    'placeholder' => 'Informations complémentaires concernant l\'adresse de livraison',
                    'rows' => '5',
                    'maxLength' => 180,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdresseLivraison::class,
        ]);
    }
}
