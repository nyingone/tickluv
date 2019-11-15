<?php

namespace App\Repository;

use App\Entity\BookingOrder;
use App\Services\ClosingPeriodService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Interfaces\BookingOrderRepositoryInterface;


final class BookingOrderRepository implements BookingOrderRepositoryInterface
{
    
    private const ENTITY = BookingOrder::class;
/**
 * Undocumented variable
 *
 * @var EntityManager
 */
   private $entityManager;

   /**
    * Undocumented variable
    *
    * @var ObjectRepository
    */
   private $objectRepository;

    /**
     * Repository by composition not inheritance
     *      
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, ClosingPeriodService $closingPeriodService)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);

        
    }


    public function find(BookingOrder $bookingOrder): ?BookingOrder
    {
        $bookingOrder = $this->objectRepository->find($bookingOrder);
        return $bookingOrder;
    }

    public function save(BookingOrder $bookingOrder): void
    {
        $this->entityManager->persist($bookingOrder);
        // $this->entityManager->flush
    }

    public function remove(BookingOrder $bookingOrder): void
    {
        $this->entityManager->remove($bookingOrder);
        // $this->entityManager->flush
    }
  
    /**
     * @param datetime $start 
     * @param datetime $end 
     * @return daysEntries[] Returns an array of days and visitor count
     */
    public function findDaysEntriesFromTo($start, $end): array
    {   
        $fromDate =  $start->format('Y-m-d');
        $toDate  =  $end->format('Y-m-d');
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT p.expected_date, count(q.id) FROM booking_order p, visitor q 
            WHERE p.id = q.booking_order_id
            AND p.expected_date >= :from_date
            AND p.expected_date <= :to_date
            AND p.validated_at <> null
            GROUP BY p.expected_date
            ORDER BY p.expected_date ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'from_date' => $fromDate,
            'to_date' => $toDate
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    

    /**
    * @return BookingOrder[] Returns an array of BookingOrder objects
    */
   
    public function findByBookingRef($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.bookingOrder = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

}
