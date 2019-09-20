<?php

namespace App\Repository;

use App\Entity\ClosingPeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClosingPeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClosingPeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClosingPeriod[]    findAll()
 * @method ClosingPeriod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClosingPeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClosingPeriod::class);
    }

    // /**
    //  * @return ClosingPeriod[] Returns an array of ClosingPeriod objects
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
    public function findOneBySomeField($value): ?ClosingPeriod
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
