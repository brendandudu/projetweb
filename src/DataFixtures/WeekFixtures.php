<?php

namespace App\DataFixtures;

use App\Entity\Week;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeekFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $date = \DateTime::createFromFormat("d/m/Y",'24/06/2021');// On commence au 24 juin, pour que la premiere semaine commence le 01/07
        $dateFin = \DateTime::createFromFormat("d/m/Y",'01/07/2021');//

        for($i = 1; $i<=8; $i++){
            $week = new Week();

            $date->modify('+7 day'); //ajout de 7 jours
            $week->setBeginsAt($date);

            $dateFin->modify('+7 day'); //ajout de 7 jours
            $week->setEndsAt($dateFin);

            $manager->persist($week);
            $this->addReference('week_'.$i, $week);

            $manager->flush(); //j'ai été obligé de mettre dans la boucle car sinon les dates étaient toutes les mêmes
        }

    }
}
