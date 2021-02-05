<?php

namespace App\DataFixtures;

use App\Entity\BookingState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookingStateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $state = [
            1 => "bloqued",
            2 => "paid",
            3 => "keys recovered",
            4 => "canceled",
            5 => "finished"
        ];


        foreach ($state as $key => $value){
            $bookingState= new BookingState();
            $bookingState->setTypeName($value);

            $manager->persist($bookingState);

            $this->addReference('state_'.$key, $bookingState);
        }

        $manager->flush();
    }
}
