<?php

namespace App\Repository;

use App\Entity\Lodging;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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
     * Return available lodgings for criteria
     */
    public function findSearch(array $search): array
    {
        $postalCodesArray = explode(";", $search['postalCodes']);

        $qb = $this->createQueryBuilder('l');

        return $qb
            ->leftJoin('l.bookings', 'b')
            ->andWhere(
                $qb->expr()->orX(
                    ':end <= b.beginsAt OR :start >= b.endsAt',     //soit il est deja dans booking, mais les dates sont libres
                    $qb->expr()->andX(                                 //soit les dates sont prises mais la réservation est annulée/terminée
                        ':start <= b.endsAt AND :end >= b.beginsAt',
                        'b.bookingState = :stateIdCanceled OR b.bookingState = :stateIdFinished'
                    ),
                    $qb->expr()->isNull('b')                        //soit il ne l'est pas encore
                )
            )
            ->andWhere('l.capacity >= :capacity')
            ->andWhere('l.postalCode IN (:CPs)')
            ->setParameters([
                'start' => $search['beginsAt']['date'],
                'end' => $search['endsAt']['date'],
                'capacity' => $search['visitors'],
                'CPs' => $postalCodesArray,
                'stateIdCanceled' => 4,
                'stateIdFinished'=> 5
            ])
            ->getQuery()
            ->getResult();
    }

}
