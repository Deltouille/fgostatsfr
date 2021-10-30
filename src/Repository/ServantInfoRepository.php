<?php

namespace App\Repository;

use App\Entity\ServantInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServantInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServantInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServantInfo[]    findAll()
 * @method ServantInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServantInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServantInfo::class);
    }

    public function findByServandIdAndUser($servant, $user)
    {
        return $this->createQueryBuilder('s')
            ->where('s.servant = :servant')
            ->setParameter('servant', $servant)
            ->andWhere('s.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return ServantInfo[] Returns an array of ServantInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServantInfo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
