<?php

namespace App\Repository;

use App\Entity\CaracteristiquesTypeHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CaracteristiquesTypeHabitat>
 *
 * @method CaracteristiquesTypeHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiquesTypeHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiquesTypeHabitat[]    findAll()
 * @method CaracteristiquesTypeHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiquesTypeHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracteristiquesTypeHabitat::class);
    }

    public function add(CaracteristiquesTypeHabitat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CaracteristiquesTypeHabitat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CaracteristiquesTypeHabitat[] Returns an array of CaracteristiquesTypeHabitat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CaracteristiquesTypeHabitat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
