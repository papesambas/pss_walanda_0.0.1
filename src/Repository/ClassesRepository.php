<?php

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\Niveaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classes>
 */
class ClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classes::class);
    }

        /**
         * Summary of findByNiveaux
         * @param \App\Entity\Niveaux $niveaux
         * @return array
         */
        public function findByNiveaux(Niveaux $niveaux): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.niveau = :niveaux')
                ->setParameter('niveaux', $niveaux)
                ->orderBy('c.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


    //    /**
    //     * @return Classes[] Returns an array of Classes objects
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

    //    public function findOneBySomeField($value): ?Classes
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
