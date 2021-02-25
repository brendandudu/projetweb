<?php

namespace App\Tests;

use App\Repository\BookingStateRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookingStateRepositoryTest extends KernelTestCase
{
    public function testCount()
    {
        $kernel = self::bootKernel();
        $users = self::$container->get(BookingStateRepository::class)->count([]);
        $this->assertEquals(5, $users);
    }
}
