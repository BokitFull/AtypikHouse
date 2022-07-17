<?php

namespace App\Repository;

use App\Entity\TypesHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypesHabitat>
 *
 * @method TypesHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypesHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypesHabitat[]    findAll()
 * @method TypesHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypesHabitat::class);
    }

    public function add(TypesHabitat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypesHabitat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return TypesHabitat[] Returns an array of TypesHabitat objects
    */
   public function GetTypesName(): array
   {
       return $this->createQueryBuilder('t')
           ->select('t.id, t.nom')
           ->getQuery()
           ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
       ;
   }
//    /**
//     * @return TypesHabitat[] Returns an array of TypesHabitat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypesHabitat
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
