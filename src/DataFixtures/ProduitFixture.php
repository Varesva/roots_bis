<?php

namespace App\DataFixtures;

use Faker\Factory;
use Stripe\Product;
use App\Entity\Produit;
use App\Entity\Specialite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixture extends Fixture
{
    private static $livreImage = [
        '5f1bef79bbfa2ebca78384286a556cf9.jpg',
        '9791029805097-cuisine-creole_g.webp',
        'DDCC6A6D-57DD-466E-AE51-6CF0D7FA47E9-e1605209779271.jpeg',
        'Gouts-d-Antilles-Recettes-et-rencontres.jpg',
        'livrec30ce5b5f9d9dbd6de7d15eefe797f26.jpg',
        'pexels-rodnae-productions-8581015.jpg',
    ];

    public function title($nbWords = 5)
    {
        $sentence = $this->generator->sentence($nbWords);
        return substr($sentence, 0, strlen($sentence) - 1);
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();

        // $faker->addProvider(new \Faker\Provider\Book($faker));
        
        // NOMBRE DE FAKER A CREER
        for ($i = 0; $i < 20; $i++) {

            $produit = new Produit();

            $produit->setTitre($faker->title);
            
            $produit->setImage($faker->randomElement(self::$livreImage));

            $produit->setPrix($faker->randomNumber(2));

            $produit->setLivreAuteur($faker->name);

            $produit->setLivreEdition($faker->company);

            $produit->setLivreResume($faker->text($faker->numberBetween(55, 200)));

            // à voir comment faire
            $produit->setCategProduit($faker->sentence($nbWords = 25, $variableNbWords = true));
            $produit->setCategNutrition($faker->sentence($nbWords = 25, $variableNbWords = true));
            $produit->setCategTypeCuisine($faker->sentence($nbWords = 25, $variableNbWords = true));

            $manager->persist($produit);
        }

        $manager->flush();
    }
}
