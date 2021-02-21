<?php

namespace App\Tests;

use App\Repository\LodgingRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LodgingRepositoryTest extends KernelTestCase
{
    public function testCount(): void
    {
        $kernel = self::bootKernel();
        $lodgings = self::$container->get(LodgingRepository::class)->count([]);

        $this->assertEquals(20, $lodgings);
    }

    public function testAvailaibleLodgings(): void
    {
        $kernel = self::bootKernel();
        $lodgings = self::$container->get(LodgingRepository::class)->findAvailableLodgings(new \DateTime('2018/11/20'),new \DateTime('2018/11/25'), 1);

        $this->assertCount(19, $lodgings);
    }
}
