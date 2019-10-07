<?php

namespace App\Repository;

use App\Entity\BookingOrder;
use App\Services\ClosingPeriodService;
use Doctrine\ORM\EntityManagerInterface;
use App\Interfaces\BookingOrderRepositoryInterface;

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


    public function find(int $id): ?BookingOrder
    {
        $bookingOrder = $this->objectRepository->find($id);
        return $bookingOrder;
    }

    public function save(BookingOrder $bookingOrder): void
    {
        $this->entityManager->persist($bookingOrder);
        // $this->entityManager->flush
    }

  
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
