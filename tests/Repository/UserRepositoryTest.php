<?php

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testCount()
    {
        $kernel = self::bootKernel();
        $users = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(20, $users);
    }

    public function testAdminRole()
    {
        $kernel = self::bootKernel();
        $admin = self::$container->get(UserRepository::class)->findOneBy(array('email' => 'admin@gmail.com'));
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $admin->getRoles());
    }

}
