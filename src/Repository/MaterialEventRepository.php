<?php

namespace App\Repository;

use App\Entity\MaterialEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialEvent[]    findAll()
 * @method MaterialEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialEvent::class);
    }

    // /**
    //  * @return MaterialEvent[] Returns an array of MaterialEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaterialEvent
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
