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

    public function testAvailableLodgings(): void
    {
        $kernel = self::bootKernel();

        $search['beginsAt']['date'] = new \DateTime('2018/11/20');
        $search['endsAt']['date']=new \DateTime('2018/11/25');
        $search['visitors'] = 1;

        $lodgings = self::$container->get(LodgingRepository::class)->findSearch($search);

        $this->assertCount(19, $lodgings);
    }

    public function testAvailableLodgingsWithCoordinate(): void
    {
        $kernel = self::bootKernel();

        $search['beginsAt']['date'] = new \DateTime('2018/11/20');
        $search['endsAt']['date']=new \DateTime('2018/11/25');
        $search['visitors'] = 1;
        $search['lat'] = 48.390394;
        $search['lng'] = -4.486076;

        $lodgings = self::$container->get(LodgingRepository::class)->findSearch($search);

        $this->assertCount(4, $lodgings);
    }
}
