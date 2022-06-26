<?php

namespace App\Repository;

use App\Entity\Notes;
use App\Entity\Habitats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notes>
 *
 * @method Notes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notes[]    findAll()
 * @method Notes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    public function add(Notes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
//     * @return Notes[] Returns an array of Notes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notes
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
