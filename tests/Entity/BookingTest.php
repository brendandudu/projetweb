<?php

namespace App\Tests;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookingTest extends KernelTestCase
{
    //TODO To finish when the booked dates constraint is created
    public function getEntity(): Booking
    {
        return (new Booking())
            ->setBeginsAt(new \DateTime('2050/11/20'))
            ->setEndsAt(new \DateTime('2050/11/25'))
            ->setTotalOccupiers(3);
    }

    public function assertHasErrors(Booking $booking, int $count = 0)
    {
        $kernel = self::bootKernel();

        $error = self::$container->get('validator')->validate($booking);
        $this->assertCount($count, $error);
    }

    public function testNegativeOccupierValue(){
        $this->assertHasErrors($this->getEntity()->setTotalOccupiers(-2), 1);
    }

    public function testNegativePriceValue(){
        $this->assertHasErrors($this->getEntity()->setTotalPricing(-2), 1);
    }
}
