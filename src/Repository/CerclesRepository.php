<?php

namespace App\Repository;

use App\Entity\Cercles;
use App\Entity\Regions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cercles>
 */
class CerclesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cercles::class);
    }

        /**
         * Summary of findByRegions
         * @param \App\Entity\Regions $regions
         * @return array
         */
        public function findByRegions(Regions $regions): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.region = :val')
                ->setParameter('val', $regions)
                ->orderBy('c.designation', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


    //    /**
    //     * @return Cercles[] Returns an array of Cercles objects
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

        /**
         * Summary of findOneByCommunes
         * @param mixed $commune
         */
        public function findOneByCommunes($commune): ?Cercles
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.communes = :val')
                ->setParameter('val', $commune)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Cercles
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
