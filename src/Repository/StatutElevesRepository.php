<?php

namespace App\Repository;

use App\Entity\Niveaux;
use App\Entity\StatutEleves;
use App\Entity\Statuts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Statuts>
 *
 * @method Statuts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statuts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statuts[]    findAll()
 * @method Statuts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutElevesRepository extends ServiceEntityRepository
{
    public const INSCRIPTION = '1ère Inscription';
    public const TRANSFERT = 'Transfert Arrivé';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutEleves::class); // Correction du nom de l'entité
    }

    /**
     * Trouve les statuts pour l'enregistrement des nouveaux élèves.
     *
     * @param Niveaux|null $niveaux Le niveau à filtrer (optionnel).
     * @return Statuts[] Retourne un tableau d'objets Statuts.
     */
    public function findStatutsForNlEnregistrement(?Niveaux $niveaux = null): array
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.designation = :inscription OR s.designation = :transfert')
            ->setParameter('inscription', self::INSCRIPTION)
            ->setParameter('transfert', self::TRANSFERT);

        if ($niveaux) {
            $qb->join('s.niveau', 'n')
               ->andWhere('n.id = :niveauId')
               ->setParameter('niveauId', $niveaux->getId());
        }

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return StatutEleves[] Returns an array of StatutEleves objects
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

    //    public function findOneBySomeField($value): ?StatutEleves
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
