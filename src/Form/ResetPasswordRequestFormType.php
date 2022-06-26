<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'help' => 'Entrer votre email pour réinitialiser votre mot de passe.',
                'label'=> 'Email',

                'attr' => [
                    'autocomplete' => 'email',
                    'placeholder' => 'email@exemple.com',
                    'class' => 'form-control',
                'maxLength' => 90,
                'maxMessage' => 'L\'email ne peut pas excéder {{limit}} caractères.'

                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre email pour réinitialiser votre mot de passe.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
