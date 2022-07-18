<?php

namespace App\Repository;

<<<<<<<< HEAD:src/Repository/CaracteristiquesHabitatRepository.php
use App\Entity\CaracteristiquesHabitat;
========
use App\Entity\CaracteristiquesTypeHabitat;
>>>>>>>> 594ea791d302c5d1567f6cedd820d524e75951b9:src/Repository/CaracteristiquesTypeHabitatRepository.php
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
<<<<<<<< HEAD:src/Repository/CaracteristiquesHabitatRepository.php
 * @extends ServiceEntityRepository<CaracteristiquesHabitat>
 *
 * @method CaracteristiquesHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiquesHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiquesHabitat[]    findAll()
 * @method CaracteristiquesHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiquesHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracteristiquesHabitat::class);
    }

    public function add(CaracteristiquesHabitat $entity, bool $flush = false): void
========
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
>>>>>>>> 594ea791d302c5d1567f6cedd820d524e75951b9:src/Repository/CaracteristiquesTypeHabitatRepository.php
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

<<<<<<<< HEAD:src/Repository/CaracteristiquesHabitatRepository.php
    public function remove(CaracteristiquesHabitat $entity, bool $flush = false): void
========
    public function remove(CaracteristiquesTypeHabitat $entity, bool $flush = false): void
>>>>>>>> 594ea791d302c5d1567f6cedd820d524e75951b9:src/Repository/CaracteristiquesTypeHabitatRepository.php
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
<<<<<<<< HEAD:src/Repository/CaracteristiquesHabitatRepository.php
//     * @return CaracteristiquesHabitat[] Returns an array of CaracteristiquesHabitat objects
========
//     * @return CaracteristiquesTypeHabitat[] Returns an array of CaracteristiquesTypeHabitat objects
>>>>>>>> 594ea791d302c5d1567f6cedd820d524e75951b9:src/Repository/CaracteristiquesTypeHabitatRepository.php
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

<<<<<<<< HEAD:src/Repository/CaracteristiquesHabitatRepository.php
//    public function findOneBySomeField($value): ?CaracteristiquesHabitat
========
//    public function findOneBySomeField($value): ?CaracteristiquesTypeHabitat
>>>>>>>> 594ea791d302c5d1567f6cedd820d524e75951b9:src/Repository/CaracteristiquesTypeHabitatRepository.php
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
