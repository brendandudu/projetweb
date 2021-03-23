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
                $password = 'Admin2021@';
            }
            else {
                if($i === 2)
                    $email = 'brokenstar@caramail.com';
                else
                    $email = $faker->email;

                $roles = ['ROLE_USER'];
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $password = 'Resa2021@';
            }

            $birthday = $faker->dateTimeThisCentury($max = 'now', $timezone = null);
            $phoneNumber = $faker->phoneNumber;
            $country = $faker->country;
            $address = $faker->address;
            $postcode = $faker->postcode;
            $city = $faker->city;

            $user -> setEmail($email);
            $user -> setRoles($roles);
            $user -> setFirstName($firstName);
            $user -> setLastName($lastName);
            $user -> setBirthday($birthday);
            $user -> setPhone($phoneNumber);
            $user -> setCountry($country);
            $user -> setAddress($address);
            $user -> setCode($postcode);
            $user -> setCity($city);
            $user -> setPassword($this->encoder->encodePassword($user, $password));

            $manager->persist($user);

            $this->addReference('user_'.$i, $user);
        }
       
        $manager->flush();
    }
    
}
