<?php

namespace App\Repository;

use App\Entity\Niveaux;
use App\Entity\Scolarites1;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Scolarites1>
 */
class Scolarites1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scolarites1::class);
    }

        public function findByNiveau(Niveaux $niveaux): array
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.niveau = :niveaux')
                ->setParameter('niveaux', $niveaux)
                ->orderBy('s.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


    //    /**
    //     * @return Scolarites1[] Returns an array of Scolarites1 objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Scolarites1
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
