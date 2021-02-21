<?php

namespace App\Tests;

use App\Repository\BookingRepository;
use App\Repository\LodgingRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookingRepositoryTest extends KernelTestCase
{
    public function testCount(): void
    {
        $kernel = self::bootKernel();
        $bookings = self::$container->get(BookingRepository::class)->count([]);

        $this->assertEquals(10, $bookings);
    }

    public function testFindBookedDateRanges(): void
    {
        $kernel = self::bootKernel();
        $lodgingTest = self::$container->get(LodgingRepository::class)->findOneBy(['name' => 'test']);
        $dateRanges= self::$container->get(BookingRepository::class)->findBookedDateRanges($lodgingTest);

        $this->assertEquals([['beginsAt' => new \DateTime('2018/11/20'),'endsAt' => new \DateTime('2018/11/25')]], $dateRanges);
    }
}
