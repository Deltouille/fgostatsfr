<?php

namespace App\Repository;

use App\Entity\CraftEssenceInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CraftEssenceInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CraftEssenceInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CraftEssenceInfo[]    findAll()
 * @method CraftEssenceInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CraftEssenceInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CraftEssenceInfo::class);
    }

    public function findByCeIdAndUser($CE, $user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.craftEssence = :ce')
            ->setParameter('ce', $CE)
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return CraftEssenceInfo[] Returns an array of CraftEssenceInfo objects
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
    public function findOneBySomeField($value): ?CraftEssenceInfo
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
