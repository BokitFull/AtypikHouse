<?php

namespace App\Repository;

use App\Entity\Habitats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitats>
 *
 * @method Habitats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitats[]    findAll()
 * @method Habitats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitats::class);
    }

    public function add(Habitats $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Habitats $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    *@ return Habitats[] Returns an array of Habitats objects
    */
   public function findByExampleField($value): array
   {
        $querry = $this->createQueryBuilder('h')
            ->select('h.libelle')
            ->addSelect('r.id, r.date_debut')
            // ->from('Habitats', 'h', 'h.id')
            // ->Where('h.id IN (:id)')
            // ->groupBy('h.id')
            ->join('h.reservations', 'r','WITH', 'r.habitat IN (:id)')
            // ->indexBy('h', 'h.libelle')
            // ->andWhere('p.category = :category')
            // ->setParameter('category', $category)
            ->setParameter('id', [1,3])
            ->orderBy('h.id', 'ASC')
        //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        
        return $querry;
   }

//    public function findOneBySomeField($value): ?Habitats
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}