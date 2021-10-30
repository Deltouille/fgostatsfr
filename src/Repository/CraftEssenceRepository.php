<?php

namespace App\Repository;

use App\Entity\CraftEssence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CraftEssence|null find($id, $lockMode = null, $lockVersion = null)
 * @method CraftEssence|null findOneBy(array $criteria, array $orderBy = null)
 * @method CraftEssence[]    findAll()
 * @method CraftEssence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CraftEssenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CraftEssence::class);
    }

    // /**
    //  * @return CraftEssence[] Returns an array of CraftEssence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CraftEssence
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
