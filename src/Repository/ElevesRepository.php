<?php

namespace App\Repository;

use App\Entity\Eleves;
use App\Entity\Classes;
use App\Entity\Cycles;
use App\Entity\Niveaux;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Eleves>
 */
class ElevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleves::class);
    }

    /**
     * Retourne tous les élèves du cycle avec des détails supplémentaires.
     *
     * @param Cycles $cycles Le cycle à filtrer.
     * @return Eleves[] Retourne un tableau d'objets Eleve.
     */
    public function findByCycleWithDetails(Cycles $cycles): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.classe', 'c') // Jointure avec Classes
            ->innerJoin('c.niveau', 'n') // Jointure avec Niveaux
            ->innerJoin('n.cycle', 'cy') // Jointure avec Cycles
            ->addSelect('c') // Sélectionne les données de la classe
            ->addSelect('n') // Sélectionne les données du niveau
            ->addSelect('cy') // Sélectionne les données du cycle
            ->andWhere('cy = :cycle') // Filtre par cycle
            ->setParameter('cycle', $cycles)
            ->orderBy('e.nom', 'ASC') // Trie par nom de l'élève
            ->addOrderBy('e.prenom', 'ASC') // Trie par nom de l'élève
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne tous les élèves du niveau
     * 
     * Summary of findByNiveauWithDetails
     * @param \App\Entity\Niveaux $niveau
     * @return Eleves[] Retourne un tableau d'objets Eleve
     */
    public function findByNiveauWithDetails(Niveaux $niveau): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.classe', 'c')
            ->innerJoin('c.niveau', 'n')
            ->addSelect('c') // Sélectionne les données de la classe
            ->addSelect('n') // Sélectionne les données du niveau
            ->andWhere('n = :niveau')
            ->setParameter('niveau', $niveau)
            ->orderBy('e.nom', 'ASC') // Trie par nom de l'élève
            ->addOrderBy('e.prenom', 'ASC') // Trie par nom de l'élève
            ->getQuery()
            ->getResult();
    }

    /**
     * Summary of findByClasses
     * @param \App\Entity\Classes $classes
     * @return array
     */
    public function findByClasses(Classes $classes): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.classe = :classes')
            ->setParameter('classes', $classes)
            ->orderBy('e.nom', 'ASC') // Trie par nom de l'élève
            ->addOrderBy('e.prenom', 'ASC') // Trie par nom de l'élève
            ->getQuery()
            ->getResult()
        ;
    }


    //    /**
    //     * @return Eleves[] Returns an array of Eleves objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Eleves
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
