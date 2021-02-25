<?php

namespace App\Repository;

use App\Entity\BookingState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookingState|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingState|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingState[]    findAll()
 * @method BookingState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingState::class);
    }
}
