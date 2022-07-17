<?php

namespace App\Repository;

use App\Entity\TypesPrestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypesPrestation>
 *
 * @method TypesPrestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypesPrestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypesPrestation[]    findAll()
 * @method TypesPrestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesPrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypesPrestation::class);
    }

    public function add(TypesPrestation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypesPrestation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return TypesPrestation[] Returns an array of TypesPrestation objects
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
//     * @return TypesPrestation[] Returns an array of TypesPrestation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypesPrestation
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
