<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $comment = new Comment();

            $lodging = $this->getReference('lodging_' . $faker->numberBetween(1, 20));
            $user = $this->getReference('user_' . $faker->numberBetween(1, 20));

            $comment->setLodging($lodging);
            $comment->setUser($user);
            $comment->setRate($faker->numberBetween(0, 5));
            $comment->setComment($faker->realText(40));

            $manager->persist($lodging);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LodgingFixtures::class,
            UserFixtures::class
        ];
    }
}
