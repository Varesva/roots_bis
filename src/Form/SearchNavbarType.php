<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchNavbarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom')

          

        

            // ->add('nom', EntityType::class, [
            // 'class' => Restaurant::class,
            // 'choice_label' => 'nom',
            // ])

            // ->add('categorie', EntityType::class, [
            // 'class' => Restaurant::class,
            // 'choice_label' => 'categorie',
            // 'expanded' => true,
            // 'multiple' => true,
            // ])

            // ->add('nutrition', EntityType::class, [
            // 'class' => Restaurant::class,
            // 'choice_label' => 'nutrition',
            // 'expanded' => true,
            // 'multiple' => true,
            // ])

            //     ->add( 'specialite', EntityType::class, [
            //     'class' => Restaurant::class,
            //     'choices' => $this->rp->findByNutrition(),
            // ])
            // ->add('nutrition')

            ->add('queryAll', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'Que recherchez-vous ?',
                    'aria-label' => 'rechercher une information',
                    'aria-describedby' => 'rechercher',
                ]
            ])

            ->add('send', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'fa-solid fa-magnifying-glass input-group-text btn-success',
                'aria-label' => 'rechercher une information',

                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Restaurant::class,
        ]);
    }
}
