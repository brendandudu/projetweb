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

    /**
     * ATTENTION : Code pas propre du tout, tout peut être regrouper en 1 requête !!
     */
    public function findAvailableLodgings(array $postalCodesArray, \DateTime $begin, \DateTime $end, int $capacity) //TODO
    {
        $bookedLodgings = $this->findBookedLodgings($postalCodesArray, $begin, $end);

        $qb = $this->createQueryBuilder('l');

        if (empty($bookedLodgings)){
            return  $qb
                ->where($qb->expr()->in('l.postalCode', ':CPs'))
                ->setParameter('CPs', $postalCodesArray)
                ->getQuery()
                ->getResult()
                ;
        }

        $availableLodgings= $qb
            ->where($qb->expr()->notIn('l.id', ':lodging'))
            ->andWhere('l.capacity >= :capacity')
            ->setParameter('lodging', $bookedLodgings)
            ->setParameter('capacity', $capacity)
            ->getQuery()
            ->getResult()
        ;

        return $availableLodgings;
    }

    private function findBookedLodgings(array $postalCodesArray, \DateTime $begin, \DateTime $end): ?array {

        $qb = $this->createQueryBuilder('l');

        return $qb
            ->select('l.id')
            ->join('l.bookings', 'b')
            ->where('b.beginsAt <= :end')
            ->andWhere('b.endsAt >= :start')
            ->andWhere($qb->expr()->in('l.postalCode', ':CPs'))
            ->setParameter('end', $end)
            ->setParameter('start', $begin)
            ->setParameter('CPs', $postalCodesArray)
            ->getQuery()
            ->getResult()
            ;
    }

}
