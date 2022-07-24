<?php

namespace App\Repository;

use App\Entity\Reservations;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function add(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Reservations[] Returns an array of Habitats objects
    */
    public function getReservationsByDate($data): array
    {   
        $month = new DateTime($data['year'] . '-' . $data['month']);
        $first_day = $month->modify('first day of this month')->format('Y-m-d');
        $last_day = $month->modify('last day of this month')->format('Y-m-d');
        $reservations = $this->createQueryBuilder('r')
            ->select('h.id AS habitat_id, r.id, r.date_debut, r.date_fin')
            ->Where('h.id IN (:id)')
            ->andWhere('r.date_debut <= :month_end')
            ->andWhere('r.date_fin >= :month_start')
            ->leftjoin('r.habitat', 'h')
            ->setParameter('id', explode(",",$data['id']))
            ->setParameter('month_start', $first_day)
            ->setParameter('month_end', $last_day)
            ->getQuery()
            ->getResult()
        ;
        
        return $reservations;
    }

//    /**
//     * @return Reservations[] Returns an array of Reservations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservations
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
