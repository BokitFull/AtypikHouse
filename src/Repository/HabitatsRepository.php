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
       ->addSelect('r')
       ->leftJoin('h.type', 't')
       ->leftJoin('h.reservations', 'r')
            ->where('1 = 1')
            ->orderBy('h.id', 'ASC')
            ;

            foreach($data as $key => $item){

                
                if ($key == 'prix' && $item != "") {
                    $query->setParameter($key, $item);
                    $query->andWhere('h.prix <= :' . $key);
                }
                else if ($key == 'nb_personnes' && $item != "") {
                    $query->setParameter($key, $item);
                    $query->andWhere('h.nb_personnes <= :' . $key);
                }
                else if ($key == 'type_habitat_id' && $item != "") {
                    $query->setParameter($key, $item);
                    $query->andWhere('t.id = :' . $key);
                }
                else if($key == 'destinations'){
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
                else if ($key == 'daterange' && $item != "") { 
                    $dateDebut = (new \DateTime(trim(explode('-', $item)[0], ' ')))->format('Y-m-d');
                    $dateFin = (new \DateTime(trim(explode('-', $item)[1], ' ')))->format('Y-m-d');

                    $query->setParameter("dtDebut", $dateDebut);
                    $query->setParameter("dtFin", $dateFin);

                    $query->andWhere('h.debut_disponibilite <= :dtFin');
                    $query->andWhere('h.fin_disponibilite >= :dtDebut');
                    $query->andWhere('r.date_debut <= :dtFin');
                    $query->andWhere('r.date_fin >= :dtDebut');
                }
                else if ($item != ""){
                    $query->setParameter($key, $item);
                    $query->andWhere('h.'.$key.' = :' . $key);
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