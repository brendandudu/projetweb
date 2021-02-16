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

    public function findAllDisponibility(\DateTime $begin, \DateTime $end, int $capacity)
    {
        return $this->createQueryBuilder('l')
            ->select('l') //on veut recuperer les hebergements
            ->where('l.capacity = :capacity')
            ->setParameter('capacity', $capacity)
            ->leftJoin('l.bookings', 'b', 'WITH', '(:begin < b.beginsAt AND :end < b.beginsAt) AND (:begin > b.endsAt AND :end > b.endsAt)')
            ->setParameter('begin', $begin)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
        ;


    }

    //(SELECT chambre
    //FROM reservation
    //WHERE  TO_DATE(:debut,'dd/mm/yy')  BETWEEN  date_reservation AND date_reservation + nb_nuits
    //    OR  TO_DATE(:debut,'dd/mm/yy') - 1 + :duree BETWEEN  date_reservation AND date_reservation + nb_nuits)

}
