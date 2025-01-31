<?php

namespace App\Repository;

use App\Entity\Telephones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Telephones>
 */
class TelephonesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telephones::class);
    }

    /**
     * @return Telephones[] Returns an array of Telephones objects
     */
    public function findAll(?int $value = null): array
    {
        // Si $value est null, utiliser 0 comme valeur par défaut
        $offset = $value ?? 0;

        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->setFirstResult($offset) // Utiliser le décalage
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Telephones[] Returns an array of Telephones objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Telephones
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
