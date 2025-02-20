<?php

namespace App\Repository;

use App\Entity\Enseignements;
use App\Entity\Etablissements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etablissements>
 */
class EtablissementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissements::class);
    }


    /**
     * Summary of findByEnseignement
     * @param \App\Entity\Enseignements $enseignements
     * @return array
     */
    public function findByEnseignement(Enseignements $enseignements): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.enseignement = :enseignement')
            ->setParameter('enseignement', $enseignements)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    //    /**
    //     * @return Etablissements[] Returns an array of Etablissements objects
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

    //    public function findOneBySomeField($value): ?Etablissements
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
