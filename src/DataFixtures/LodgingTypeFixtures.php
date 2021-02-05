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
            1 => "chalet",
            2 => "bungalow",
            3 => "mobil-home",
            4 => "flat",
            5 => "house",
        ];


        foreach ($types as $key => $value){
            $lodgingType = new LodgingType();
            $lodgingType->setTypeName($value);

            $manager->persist($lodgingType);

            $this->addReference('type_'.$key, $lodgingType);
        }

        $manager->flush();
    }
}
