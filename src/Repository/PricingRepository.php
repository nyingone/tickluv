<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pricing;
use App\Interfaces\PricingRepositoryInterface;

/**
 * @method Pricing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricing[]    findAll()
 * @method Pricing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingRepository implements PricingRepositoryInterface
{

    private $entityManager;

    private $pricingrepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
      //  $this->entityManager = $entityManager;
       // $this->pricingrepository = $this->entityManager->getRepository(Pricing::class);

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
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM pricing p
            WHERE p.termDate >= :date
            AND p.discounted = :discounted
            AND p.partTimeCode = :partTimeCode
            AND p.ageMin <= :yearsOld                     
            AND p.ageMax > :yearsOld
            ORDER BY p.termDate DESC
            ';
      /*  $stmt = $conn->prepare($sql);
        $stmt->execute([
            'date' => $date,
            'discounted' => $discounted,
            'partTimeCode' => $partTimeCode,
            'yearsOld'  => $yearsOld
            ]); */

            return ['xx'];
    // returns an array of arrays (i.e. a raw data set)
     //   return $stmt->fetchAll();
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
