<?php

namespace App\Repository;

use App\Entity\Pricing;
use App\Interfaces\PricingRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Pricing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricing[]    findAll()
 * @method Pricing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingRepository implements PricingRepositoryInterface
{

    private const ENTITY= Pricing::class;
    private $entityManager;
    private $objectRepository;
    private $pricingrepository;
    private  $conn;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->conn = $this->entityManager->getConnection();
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);

       // $this->pricingrepository = $this->entityManager->getRepository(Pricing::class);

    }

    public function findAll()
    {

    }


    public function findLastTarifDate($date)
    {
      $dateRef =  $date->format('Y-m-d');
   
      $sql = '
          SELECT max(term_date) FROM pricing p
          WHERE p.term_date <= :date_ref
          ORDER BY p.term_date DESC
          ';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
          'date_ref' => $dateRef
          ]);

          return $stmt->fetchAll();
    }
   
    /**
     * @param $expectedDate 
     * @param $partTimeCode
     * @param $discounted
     * @param $yearsomd
     * @return []
     */
    public function findLastPricing($date, $partTimeCode, $discounted, $yearsOld): array
          {
        // $dateRef =  $date->format('Y-m-d');
/*
        $sql = '
            SELECT * FROM pricing p
            WHERE p.term_date = :date_ref 
            AND (p.part_time_code is null OR p.part_time_code = :part_time_code )
            AND p.discounted = :discounted        
            AND p.age_min <= :years_old                     
            AND p.age_max > :years_oldx
           
            ORDER BY p.part_time_code ASC
            ';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'date_ref' => $dateRef,
            'part_time_code' => $partTimeCode,
            'discounted' => $discounted,
            'years_old'  => \ intval($yearsOld),
            'years_oldx'  => \ intval($yearsOld)
            ]);

       return $stmt->fetchAll();

       */
 // * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
       return $this->objectRepository->findby([
            'termDate' => $date,
            'discounted' => $discounted
       ]
    );
      
 
    }
       
    // /**
    //  * @return Pricing[] Returns an array of Pricing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pricing
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
