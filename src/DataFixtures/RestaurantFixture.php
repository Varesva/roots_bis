<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Restaurant;
use App\Entity\Specialite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RestaurantFixture extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();
        for ($i=0; $i < 20; $i++) {
            $restaurant = new Restaurant();
            $restaurant->setNom($faker->company);
            
            $restaurant->setImage($faker->imageUrl($width = 640, $height = 480));
            
            $restaurant->setDescription($faker->sentence($nbWords = 25, $variableNbWords = true));

            // $restaurant->setSpecialite();
            
            $restaurant->setCodePostal($faker->postcode);
            $restaurant->setVille($faker->city);

            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
