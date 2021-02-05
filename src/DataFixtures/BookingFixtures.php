<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i=1;$i<=10;$i++){
            $booking = new Booking();
            $lodging = $this->getReference('lodging_'.$faker->numberBetween(1,20));

            $booking->setLodging($lodging);
            $booking->setUser($this->getReference('user_'.$faker->numberBetween(1,20)));
            $booking->setWeek($this->getReference('week_'.$faker->numberBetween(1,8))); //attention verifier week
            $booking->setBookingState($this->getReference('state_'.$faker->numberBetween(1,5)));

            $booking->setTotalOccupiers($faker->numberBetween(1,$lodging->getCapacity()));
            $booking->setTotalPricing($lodging->getWeeklyPricing());
            $booking->setNote($faker->numberBetween(0,5));
            $manager-> persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            UserFixtures::class,
            LodgingFixtures::class,
            WeekFixtures::class,
            BookingStateFixtures::class
        ];
    }
}
