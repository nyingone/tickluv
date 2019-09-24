<?php

namespace App\Repository;

use App\Entity\BookingOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingOrder[]    findAll()
 * @method BookingOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingOrder::class);
    }

    // /**
    //  * @return BookingOrder[] Returns an array of BookingOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookingOrder
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

/**
 * 
 */
    
    /**
     * @param datetime $start 
     * @param datetime $end 
     * @return daysEntries[] Returns an array of days and visitor count
     */
    public function findDaysEntriesFromTo($start, $end): array
    {   
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT p.expectedDate, p.count as p.visitorCount FROM BookingOrder p
            WHERE p.expectedDate >= :start
            AND p.expectedDate <= :end
            AND p.validatedAt nt null
            ORDER BY p.expectedDate ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'start' => $start,
            'end' => $end
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

}
