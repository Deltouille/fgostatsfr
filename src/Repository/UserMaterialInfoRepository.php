<?php

namespace App\Repository;

use App\Entity\UserMaterialInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserMaterialInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMaterialInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMaterialInfo[]    findAll()
 * @method UserMaterialInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMaterialInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMaterialInfo::class);
    }

    // /**
    //  * @return UserMaterialInfo[] Returns an array of UserMaterialInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMaterialInfo
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
