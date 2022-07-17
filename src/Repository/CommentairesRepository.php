<?php

namespace App\Repository;

use App\Entity\Commentaires;
use App\Entity\Habitats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaires>
 *
 * @method Commentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaires[]    findAll()
 * @method Commentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaires::class);
    }

    public function add(Commentaires $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commentaires $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByHabitat(Habitats $entity) {
        return 
        $this->createQueryBuilder('c')
        ->select('c')
        ->leftJoin('c.reservation', 'r')
        ->leftJoin('r.habitat', 'h')
        ->andWhere('h.id = :id')
        ->setParameter('id', $entity->getId())
        ->getQuery()
        ->getResult();
    }

    public function findNotesMoyennesByHabitat(Habitats $entity) : Array {
        return 
        $this->createQueryBuilder('n')
        ->select('
            AVG(n.note_proprete) note_proprete, 
            AVG(n.note_accueil) note_accueil, 
            AVG(n.note_emplacement) note_emplacement, 
            AVG(n.note_qualite_prix) note_qualite_prix, 
            AVG(n.note_equipements) note_equipements, 
            ((n.note_proprete + n.note_accueil + n.note_emplacement + n.note_qualite_prix + n.note_equipements) / 5) note_generale')
        ->leftJoin('n.reservation', 'r')
        ->leftJoin('r.habitat', 'h')
        ->andWhere('h.id = :id')
        ->setParameter('id', $entity->getId())
        ->getQuery()
        ->getResult();                       
    }

//    /**
//     * @return Commentaires[] Returns an array of Commentaires objects
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

//    public function findOneBySomeField($value): ?Commentaires
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
