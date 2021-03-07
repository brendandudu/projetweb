<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findBookedDateRanges($lodgingId) : ?array
    {
        return $this->createQueryBuilder('b')
            ->select('b.beginsAt', 'b.endsAt')
            ->join('b.lodging', 'l')
            ->where('l.id = :id')
            ->setParameter('id', $lodgingId)
            ->getQuery()
            ->getResult();
    }

    public function findByOwnerId($ownerId)
    {
        return $this->createQueryBuilder('b')
            ->join('b.lodging', 'l')
            ->where('l.user = :id')
            ->setParameter('id', $ownerId)
            ->getQuery()
            ->getResult();
    }

}
