<?php

namespace App\DataFixtures;

use App\Entity\Lodging;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
Use Faker;

class LodgingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //fake latitude & longitude in Saint Tropez
        $geo = [
            1 => ["lat" => -89.96434100, "lon" => 121.74843300],
            2 => ["lat" => 43.277753, "lon" => 6.678500],
            3 => ["lat" => 43.277539, "lon" => 6.679179],
            4 => ["lat" => 43.276828, "lon" => 6.680383],
            5 => ["lat" => 43.278836, "lon" => 6.677947]
        ];

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++) {
            $lodging = new Lodging();

            if($i <= 5){ //Brest
                $lodging->setLat($faker->latitude(48.382359, 48.389359));
                $lodging->setLon($faker->longitude(-4.465491, -4.48491));

                $lodging->setPostalCode('29200');
            }
            elseif ($i <= 10){ //Paris
                $lodging->setLat($faker->latitude(48.840233, 48.891895));
                $lodging->setLon($faker->longitude(2.304609, 2.357188));

                $lodging->setPostalCode('75001'); //Attention pas forcement dans 1er arrondissement
            }
            elseif($i <= 15){ //Marseille
                $lodging->setLat($faker->latitude(43.270741, 43.293684));
                $lodging->setLon($faker->longitude(5.357497, 5.397497));

                $lodging->setPostalCode('13000');
            }
            else{ //Bordeaux
                $lodging->setLat($faker->latitude(44.830342, 44.840342));
                $lodging->setLon($faker->longitude(-0.559277, -0.599277));

                $lodging->setPostalCode('33000');
            }




            //$lodging->setLat($faker->latitude(43.57639, 43.60639));
            //$lodging->setLon($faker->longitude(3.96306, 3.98306));

            $lodging->setFullAddress($faker->realText(50));
            $lodging->setName($faker->realText(20));
            $lodging->setLodgingType($this->getReference('type_' . $faker->numberBetween(1, 5)));
            $lodging->setNightPrice($faker->numberBetween(45, 120));
            $lodging->setSpace($faker->numberBetween(10, 30));
            $lodging->setInternetAvailable($faker->numberBetween(0, 1));
            $lodging->setCurrentCondition($faker->realText(25));
            $lodging->setCapacity($faker->numberBetween(1, 8));
            $lodging->setDescription($faker->realText(300));


            $lodging->setPicture("https://manager.groupe-bdl.com/web_content/modeles/114-modele-maison-individuelle-a-etage-1.jpg");

            $manager->persist($lodging);

            $this->addReference('lodging_'.$i, $lodging);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            LodgingTypeFixtures::class
        ];
    }
}
