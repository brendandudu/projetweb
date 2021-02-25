<?php

namespace App\Tests;

use App\Entity\Lodging;
use PHPUnit\Framework\TestCase;

class AppPhpTest extends TestCase
{
    public function testLodgingClass()
    {
        $lodging = new Lodging();
        $lodging->setSpace(28);
        $lodging->setName('testLodging');
        self::assertEquals(28, $lodging->getSpace());
        self::assertEquals('testLodging', $lodging->getName());
    }

    public function testLodgingToString()
    {
        $lodging = new Lodging();
        $lodging->setName('HebTest');
        self::assertEquals('HebTest', $lodging->__toString());
    }

}
