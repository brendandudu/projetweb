<?php

namespace App\DataFixtures;

use App\Entity\LodgingType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LodgingTypeFixtures extends Fixture
{

    const TYPE_1 = 'chalet';
    const TYPE_2 = 'bungalow';
    const TYPE_3 = 'mobil-home';
    const TYPE_4 = 'flat';
    const TYPE_5 = 'house';

    public function load(ObjectManager $manager)
    {
        $lodgingType1 = new LodgingType();
        $lodgingType1->setTypeName('Chalet');

        $manager->persist($lodgingType1);

        $lodgingType2 = new LodgingType();
        $lodgingType2->setTypeName('Bungalow');

        $manager->persist($lodgingType2);

        $lodgingType3 = new LodgingType();
        $lodgingType3->setTypeName('Mobil-home');

        $manager->persist($lodgingType3);

        $lodgingType4 = new LodgingType();
        $lodgingType4->setTypeName('Flat');

        $manager->persist($lodgingType4);

        $lodgingType5 = new LodgingType();
        $lodgingType5->setTypeName('House');

        $manager->persist($lodgingType5);

        $this->addReference(self::TYPE_1, $lodgingType1);
        $this->addReference(self::TYPE_2, $lodgingType2);
        $this->addReference(self::TYPE_3, $lodgingType3);
        $this->addReference(self::TYPE_4, $lodgingType4);
        $this->addReference(self::TYPE_5, $lodgingType5);

        $manager->flush();
    }
}
