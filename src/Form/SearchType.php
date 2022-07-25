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

class SearchType extends AbstractType
{
    // private $rp;
    // public function __construct(RestaurantRepository $rp)
    // {
    //     $this->rp = $rp;
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom')
            // ->setAction('app_search')

            // RECHERCHE NOM, SPECIALITE, NUTRITION, (CATEGORIE):pas sure
            ->add('query', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'Restaurant, type de cuisine/nutrition...',
                    'aria-label' => 'rechercher un restaurant',
                    'aria-describedby' => 'rechercheInfo',
                ]
            ])

            // RECHERCHE VILLE, CODE_POSTAL
            ->add('queryLocation', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'Localisation (ville ou code postal)',
                    'aria-label' => 'rechercher des restaurants par localisation',
                    'aria-describedby' => 'rechercheInfoLocalisation',
                ]
            ])

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

            ->add('send', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-danger'
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
