<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecommanderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'help' => 'Email où vous recontacter, si besoin',
                'attr' => [
                    'placeholder' => 'email@exemple.com',
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                    'maxLength' => 50,
                    'minLength' => 8,
                ]
            ])
            ->add('restaurant', TextType::class, [
                'attr' => [
                    'placeholder' => 'Resto recommandé',
                    'class' => 'form-control',
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

            ->add('message', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quel est votre coup de cœur ?  (Les plats, le lieu, le personnel, l\'histoire ?...). Dites-nous tout !',
                    'rows' => '5',
                    'maxLength' => 1000,
                ]
            ])

            ->add('send', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
