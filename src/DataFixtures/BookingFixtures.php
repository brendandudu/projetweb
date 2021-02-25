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

            if($i===1) { //le lodging pour les tests
                $lodging = $this->getReference('lodging_1');
                $beginsAt = new \DateTime('2018/11/20');
                $endsAt = new \DateTime('2018/11/25');

            }
            else {
                $lodging = $this->getReference('lodging_'.$faker->numberBetween(2,20));
                $beginsAt = $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now', $timezone = null);
                $endsAt = $faker->dateTimeBetween($startDate = 'now', $endDate = '+7 days', $timezone = null);
            }

            $booking->setLodging($lodging);

            $booking->setUser($this->getReference('user_'.$faker->numberBetween(1,20)));
            $booking->setBeginsAt($beginsAt);
            $booking->setEndsAt($endsAt);
            $booking->setBookingState($this->getReference('state_'.$faker->numberBetween(1,5)));

            $booking->setTotalOccupiers($faker->numberBetween(1,$lodging->getCapacity()));
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
            BookingStateFixtures::class
        ];
    }
}
