<?php

namespace App\Repository;

use App\Entity\Invocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invocation[]    findAll()
 * @method Invocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invocation::class);
    }

    // /**
    //  * @return Invocation[] Returns an array of Invocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invocation
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
