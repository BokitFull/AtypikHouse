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
    public function findByHabitats($data): array
    {
        $query = $this->createQueryBuilder('h')
                      ->select('h')
                      ->orderBy('h.id', 'ASC')
             ;
             
        foreach($data as $key => $value){
            $query ->setParameter($key, $value);
            if($key == 'prix'){
                $query ->andWhere('h.'.$key.' <= :'.$key);
            }
            elseif($key == 'nb_personnes'){
                $query ->andWhere('h.'.$key.' >= :'.$key);
            }
            elseif($key == 'types'){
                $query ->leftJoin('h.type', 't') 
                       ->andWhere('t.id = :'.$key);
            }
            elseif($key == 'destinations'){
                $destinations = explode(";", $value);
                $query ->leftJoin('h.ville', 'v')
                       ->setParameter($key, $destinations[0]);
                if($destinations[1] == 'regions'){
                    $query->leftJoin('v.departements', 'd')
                          ->leftJoin('d.region', 'r')
                          ->andWhere('r.nom = :'.$key);
                }elseif($destinations[1] == 'departements'){
                    $query->leftJoin('v.departements', 'd')
                          ->andWhere('d.nom = :'.$key);
                }elseif($destinations[1] == 'villes'){
                    $query->andWhere('v.nom = :'.$key);
                }
            }
            else{
                $query ->andWhere('h.'.$key.' = :'.$key);
            }
        }
             
        $nb = $query->getQuery()
                    ->getResult();

        return $nb;
    }
 
    /**
     * récupération des départements pour les afficher dans le filtre
     *
     *@ return Habitats[] Returns an array of Habitats objects
     */
    public function findByDep(): array
    {
 
         $query = $this->createQueryBuilder('h')
             ->select('DISTINCT h.code_postal')
             ->getQuery()
             ->getResult()
         ;
         
         return $query;
    }
//    /**
//     * @return Habitats[] Returns an array of Habitats objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

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
