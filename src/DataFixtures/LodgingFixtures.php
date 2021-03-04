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
        /*Lodging fixtures in France*/

        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new Faker\Provider\fr_FR\Address($faker));

        for ($i = 1; $i <= 20; $i++) {
            $lodging = new Lodging();

            if($i <= 5){ //Brest
                $lodging->setLat($faker->latitude(48.382359, 48.389359));
                $lodging->setLon($faker->longitude(-4.465491, -4.48491));

                $postalCode = '29200';
                $cityName = "Brest";
                $regionName = "Bretagne";
            }
            elseif ($i <= 10){ //Paris
                $lodging->setLat($faker->latitude(48.840233, 48.891895));
                $lodging->setLon($faker->longitude(2.304609, 2.357188));

                $postalCode = $faker->numberBetween(75000, 75020); //arrondissement pas forcement cohérent avec lat et lon (juste dans les fixtures)
                $cityName = "Paris";
                $regionName = "Ile-de-France";
            }
            elseif($i <= 15){ //Marseille
                $lodging->setLat($faker->latitude(43.270741, 43.293684));
                $lodging->setLon($faker->longitude(5.357497, 5.397497));

                $postalCode = '13000';
                $cityName = "Marseille";
                $regionName = "Provence-Alpes-Côte d'Azur";
            }
            else{ //Bordeaux
                $lodging->setLat($faker->latitude(44.830342, 44.840342));
                $lodging->setLon($faker->longitude(-0.559277, -0.599277));

                $postalCode = '33000';
                $cityName = "Bordeaux";
                $regionName = "Nouvelle-Aquitaine";
            }


            $lodging->setPostalCode($postalCode);
            $lodging->setFullAddress($faker->streetAddress.",".$cityName.",".$regionName.",".$postalCode.", France");
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
