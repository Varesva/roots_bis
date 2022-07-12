<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Restaurant;
use App\Entity\Specialite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RestaurantFixture extends Fixture
{
    private static $restoImage = [
        'afrikn-2-626fd2a01a069.jpg',
        'plantain-62c40e90c1a9e.jpg',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();
        for ($i=0; $i < 20; $i++) {
            $restaurant = new Restaurant();
            $restaurant->setNom($faker->company);
            
            $restaurant->setImage($faker->randomElement(self::$restoImage));
            
            $restaurant->setDescription($faker->sentence($nbWords = 25, $variableNbWords = true));

            // $restaurant->setSpecialite();
            
            $restaurant->setCodePostal($faker->postcode);
            $restaurant->setVille($faker->city);

            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
