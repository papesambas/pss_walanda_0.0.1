<?php

namespace App\Repository;

use App\Entity\Cycles;
use App\Entity\Niveaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Niveaux>
 */
class NiveauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Niveaux::class);
    }

        /**
         * Summary of findByCycle
         * @param \App\Entity\Cycles $cycles
         * @return array
         */
        public function findByCycle(Cycles $cycles): array
        {
            return $this->createQueryBuilder('n')
                ->andWhere('n.cycle = :cycles')
                ->setParameter('cycles', $cycles)
                ->orderBy('n.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


    //    /**
    //     * @return Niveaux[] Returns an array of Niveaux objects
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
    

    //    public function findOneBySomeField($value): ?Niveaux
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
