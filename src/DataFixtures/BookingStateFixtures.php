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
            1 => "Bloqued",
            2 => "Paid",
            3 => "Keys recovered",
            4 => "Canceled",
            5 => "Finished"
        ];


        foreach ($state as $key => $value) {
            $bookingState = new BookingState();
            $bookingState->setId($key);
            $bookingState->setTypeName($value);

            $manager->persist($bookingState);

            $this->addReference('state_' . $key, $bookingState);
        }

        $manager->flush();
    }
}
