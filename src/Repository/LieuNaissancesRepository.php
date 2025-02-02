<?php

namespace App\Repository;

use App\Entity\Communes;
use App\Entity\LieuNaissances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LieuNaissances>
 */
class LieuNaissancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LieuNaissances::class);
    }

    public function findByCommunes(Communes $communes): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.commune = :val')
            ->setParameter('val', $communes)
            ->orderBy('l.designation', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return LieuNaissances[] Returns an array of LieuNaissances objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LieuNaissances
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
