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
                $user -> setEmail('admin@gmail.com');
                $user ->setRoles(['ROLE_ADMIN']);
                $user -> setFirstName('admin');
                $user -> setLastName('admin');
                $user -> setPassword($this->encoder->encodePassword($user, 'admin'));
            }
            else {
                $user -> setEmail($faker->email);
                $user->setRoles(['ROLE_USER']);
                $user -> setFirstName($faker->firstName);
                $user -> setLastName($faker->lastName);
                $user -> setPassword($this->encoder->encodePassword($user, 'azerty'));
            }


            $manager->persist($user);

            $this->addReference('user_'.$i, $user);
        }
       
        $manager->flush();
    }
    
}
