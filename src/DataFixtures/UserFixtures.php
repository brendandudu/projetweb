<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++){
            $user = new User();

            if($i === 1){ //Admin
                $email = 'admin@gmail.com';
                $roles = ['ROLE_ADMIN'];
                $firstName = 'admin';
                $lastName = 'admin';
            }
            else if ($i === 2){ //Host
                $email = 'host@gmail.com';
                $roles = ['ROLE_HOST'];
                $firstName = 'host';
                $lastName = 'host';
            }
            else {
                if($i === 3) // Guest
                    $email = 'guest@gmail.com';
                else
                    $email = $faker->email;

                $roles = ['ROLE_USER'];
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
            }

            $password = "Resa2021@";
            $user ->setEmail($email);
            $user ->setRoles($roles);
            $user -> setFirstName($firstName);
            $user -> setLastName($lastName);
            $user -> setPassword($this->encoder->encodePassword($user, $password));

            $manager->persist($user);

            $this->addReference('user_'.$i, $user);
        }
       
        $manager->flush();
    }
    
}
