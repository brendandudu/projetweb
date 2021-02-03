<?php

namespace App\DataFixtures;

use App\DataFixtures\LodgingTypeFixtures;
use App\Entity\Lodging;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LodgingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($count = 0; $count < 5; $count++) {
            $lodging = new Lodging();

            $lodging->setName('Lodging'.$count);
            $lodging->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $lodging->setCapacity(rand (1, 8));
            $lodging->setCurrentCondition('sud');
            $lodging->setInternetAvailable(true);
            $lodging->setSpace(rand (10, 30));
            $lodging->setWeeklyPricing(rand (300, 750));
            $lodging->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_.$count));

            $manager->persist($lodging);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LodgingTypeFixtures::class,
        );
    }
}
