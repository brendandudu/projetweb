<?php

namespace App\DataFixtures;

use App\Entity\LodgingType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LodgingTypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $types = [
            1 => "Chalet",
            2 => "Bungalow",
            3 => "Mobil-home",
            4 => "Flat",
            5 => "House",
        ];


        foreach ($types as $key => $value) {
            $lodgingType = new LodgingType();
            $lodgingType->setId($key);
            $lodgingType->setTypeName($value);

            $manager->persist($lodgingType);

            $this->addReference('type_' . $key, $lodgingType);
        }

        $manager->flush();
    }
}
