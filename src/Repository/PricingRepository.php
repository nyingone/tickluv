<?php

namespace App\Repository;

use App\Entity\Pricing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Config\Definition\FloatNode;

/**
 * @method Pricing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricing[]    findAll()
 * @method Pricing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pricing::class);
    }

   
    /**
     * @param $expectedDate 
     * @param $partTimeCode
     * @param $discounted
     * @param $yearsomd
     * @return $cost
     */
    public function findLastPricing($expectedDate, $partTimeCode, $discounted, $yearsOld): Float
    {
      {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM pricing p
            WHERE p.termDate >= :expecteddate
            AND p.discounted = :discounted
            AND p.partTimeCode = :partTimeCode
            AND p.ageMin <= :yearsOld
            AND p.ageMax > :yearsOld
            ORDER BY p.termDate DESC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'expectedDate' => $expectedDate,
            'discounted' => $discounted,
            'partTimeCode' => $partTimeCode,
            'yearsOld'  => $yearsOld
            ]);

    // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
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
