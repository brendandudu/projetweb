<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function getEntity(): User
    {
        return (new User())
            ->setPassword('Resa2021@')
            ->setFirstName('test')
            ->setLastName('test')
            ->setEmail('test@gmail.com');
    }

    private function assertHasErrors(User $user, int $count = 0)
    {
        $kernel = self::bootKernel();

        $error = self::$container->get('validator')->validate($user);
        $this->assertCount($count, $error);
    }

    public function testValidPassword(){
       $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidPassword(){
        $this->assertHasErrors($this->getEntity()->setPassword('Test20@'), 1); //7/8 chars
        $this->assertHasErrors($this->getEntity()->setPassword('Test2021'), 1); //missing special char
        $this->assertHasErrors($this->getEntity()->setPassword('T12345@@'), 1); //missing lowercase char
        $this->assertHasErrors($this->getEntity()->setPassword('test2021@'), 1); //missing uppercase char
        $this->assertHasErrors($this->getEntity()->setPassword('Testtest@'), 1); //missing number
    }

    public function testInvalidBlankPassword(){
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }

    public function testValidEmail(){
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEmail(){
        $this->assertHasErrors($this->getEntity()->setEmail('test/email'), 1);
    }

    public function testInvalidBlankEmail(){
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testAlreadyUsedEmail(){
        $this->assertHasErrors($this->getEntity()->setEmail('guest@gmail.com'), 1);
    }
}
