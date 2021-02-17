<?php

namespace App\Repository;

use App\Entity\Lodging;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lodging|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lodging|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lodging[]    findAll()
 * @method Lodging[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LodgingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lodging::class);
    }

    public function findAvailableLodgings(\DateTime $begin, \DateTime $end, $capacity)
    {

        $bookedLodgings = $this->findBookedLodgings($begin, $end, $capacity);

        $qb = $this->createQueryBuilder('l');

        $availableLodgings= $qb
            ->andWhere($qb->expr()->notIn('l.id', ':lodging'))
            ->andWhere('l.capacity >= :capacity')
            ->setParameter('lodging', $bookedLodgings)
            ->setParameter('capacity', $capacity)
            ->getQuery()
            ->getResult()
        ;

        return $availableLodgings;
    }

    private function findBookedLodgings(\DateTime $begin, \DateTime $end){

        return $this->createQueryBuilder('l')
            ->select('l.id')
            ->join('l.bookings', 'b')
            ->where('b.beginsAt <= :end')
            ->andWhere('b.endsAt >= :start')
            ->setParameter('end', $end)
            ->setParameter('start', $begin)
            ->getQuery()
            ->getResult()
        ;
    }
}
