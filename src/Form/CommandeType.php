<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',  DateType::class, [
                'label' => 'Date de commande*',
                'label_attr' => [
                    'class' => 'form-label label',
                ],
            ])

            ->add('total_facturation', MoneyType::class, [
                'html5' => true,
                'label' => 'Total facturation (€)*'
            ])

            ->add('reference', TextType::class, [
                'label' => 'Référence*',

            ])

            ->add('user', TextType::class, [
                'label' => 'Prénom utilisateur*',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
