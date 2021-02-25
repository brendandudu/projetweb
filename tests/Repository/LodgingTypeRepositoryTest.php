<?php

namespace App\Tests;

use App\Repository\LodgingTypeRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LodgingTypeRepositoryTest extends KernelTestCase
{
    public function testCount()
    {
        $kernel = self::bootKernel();
        $users = self::$container->get(LodgingTypeRepository::class)->count([]);
        $this->assertEquals(5, $users);
    }
}
