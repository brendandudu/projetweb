<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Lodging;
use App\Entity\Week;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Week|null find($id, $lockMode = null, $lockVersion = null)
 * @method Week|null findOneBy(array $criteria, array $orderBy = null)
 * @method Week[]    findAll()
 * @method Week[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Week::class);
    }

    public function findWeeksAvailaible($id)
    {

        $qb1 = $this->createQueryBuilder('w'); //récupère les semaines utilisées par l'hebergement

        $usedWeeks = $qb1
            ->select('w.id')
            ->join('w.bookings', 'b')
            ->join('b.lodging', 'l')
            ->andWhere('l.id = :id')
            ->setParameter('id', $id)
            ->orderBy('w.beginsAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;


        $qb2 = $this->createQueryBuilder('w'); //récupère les semaines différentes de celles utilisées (not in)

        $availableWeeks = $qb2
            ->andWhere($qb2->expr()->notIn('w.id', ':weeks'))
            ->setParameter('weeks', $usedWeeks)
            ->getQuery()
            ->getResult()
            ;

        return $availableWeeks;
    }

}
