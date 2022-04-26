<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            'attr' => [
                'placeholder' => 'email@exemple.com',
                'class' => 'form-control'
            ]
        ])
            ->add('resto', TextType::class, [
                'attr' => [
                    'placeholder' => 'Je conseille ...',
                    'class' => 'form-control'
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Bonjour, je vous recommande le restaurant suivant : ... parce que ...',
                    'class' => 'contact_form_control',
                    'rows' => '5'
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg'
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
