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
       ->leftJoin('h.TypeHabitat', 't')
            ->Where('1=1')
            // ->andWhere('h.code_postal = :code_postal')
            // ->setParameter('price', $data['price'])
            // ->setParameter('code_postal', $data['code_postal'])
            ->orderBy('h.id', 'ASC')
            ;
            
            
            
            foreach($data as $key => $item){
                $query  ->setParameter($key, $item);
                if($key == 'prix'){
                    $query ->andWhere('h.'.$key.' <= :'.$key);
                }
                elseif ($key == 'nombre_personnes_max') {
                    $query ->andWhere('h.'.$key.' >= :'.$key);
                }
                elseif ($key == 'type_habitat_id') {
                    $query ->andWhere('t.id = :'.$key);
                }
                else{
                    $query ->andWhere('h.'.$key.' = :'.$key);
                }
            }
            
            $nb = $query->getQuery()
            ->getResult();
            // var_dump($query->getQuery());die;
            

        // $query->andWhere('h.code_postal = :code_postal');
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