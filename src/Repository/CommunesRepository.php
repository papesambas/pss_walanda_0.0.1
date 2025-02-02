<?php

namespace App\Repository;

use App\Entity\Cercles;
use App\Entity\Communes;
use App\Entity\LieuNaissances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Communes>
 */
class CommunesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Communes::class);
    }

        /**
         * Summary of findByCercles
         * @param \App\Entity\Cercles $cercles
         * @return array
         */
        public function findByCercles(Cercles $cercles): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.cercle = :val')
                ->setParameter('val', $cercles)
                ->orderBy('c.designation', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        /**
         * Summary of findByCercles
         * @param \App\Entity\Cercles $cercles
         * @return array
         */
        public function findByLieuNaissances(LieuNaissances $lieuNaissances): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.lieuNaissance = :val')
                ->setParameter('val', $lieuNaissances)
                ->orderBy('c.designation', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


    //    /**
    //     * @return Communes[] Returns an array of Communes objects
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
         * Summary of findOneByLieuNaissances
         * @param mixed $lieuNaissance
         */
        public function findOneByLieuNaissances($lieuNaissance): ?Communes
        {
            return $this->createQueryBuilder('c')
               ->andWhere('c.lieuNaissances = :val')
                ->setParameter('val', $lieuNaissance)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }


    //    public function findOneBySomeField($value): ?Communes
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
