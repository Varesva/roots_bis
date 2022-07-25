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
        'dinnertable-62de8a796360d.jpg',
        'plantain-62c40e90c1a9e.jpg',
        'assiette_mic_mac.png',
        'dinnertable-62de8a796360d.jpg',
        'maxresdefault.jpg',
        'numero-mag-chef-gloria-kabe-afrovegan1.webp',
        'pexels-mumtahina-tanni-6260921.jpg',
        'pexels-picha-6210433.jpg',
        'pexels-picha-6210449.jpg',
        'pexels-rajesh-tp-1624487.jpg',
        'pexels-valeria-boltneva-1893555.jpg',
        'Photo_Oct_30__3_11_34_PM.0.webp',
        'restaurant-caffe-creole2.jpg',
        'restaurant-Villa-Maasai-paris.webp',
        'tumblr_mmgfb3naQX1qjr9dao1_1280.jpg',
    ];

    private static $codePostal = [
        '75010',
        '91530',
        '94500',
        '92000',
        '93460',
        '75002',
        '75006',
        '95840',
        '95300',
        '95270',
        '95380',
        '75010',
        '91940',
        '91840',
        '92430',
        '94220',
        '94320',
        '95420',
        '94510',
        '75011',
        '75012',
        '75013',
        '75014',
        '75015',
        '75016',
        '75017',
        '75018',
        '75019',
        '75020',
    ];

    private static $ville = [
        'Paris 01',
        'Paris 04',
        'Paris 05',
        'Paris 06',
        'Paris 07',
        'Paris 08',
        'Paris 09',
        'Paris 10',
        'Paris 11',
        'Paris 12',
        'Paris 13',
        'Paris 14',
        'Paris 15',
        'Paris 16',
        'Paris 17',
        'Paris 18',
        'Paris 19',
        'Paris 20',
        'Paris 16',
        'Goussonville',
        'Clichy-Sous-Bois',
        'Gournay-Sur-Marne',
        'Neuilly-Sur-Marne',
        'Villepinte',
        'Créteil',
        'Nogent-Sur-Marne',
        'Rungis',
        'Bobigny',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {

            $restaurant = new Restaurant();

            $restaurant->setNom($faker->company);

            $restaurant->setImage($faker->randomElement(self::$restoImage));

            $restaurant->setDescription($faker->text($faker->numberBetween(25, 100)));

            $restaurant->setCodePostal($faker->randomElement(self::$codePostal));
            
            $restaurant->setVille($faker->randomElement(self::$ville));

            
            // $restaurant->setSpecialite();
            
            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
