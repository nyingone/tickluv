<?php

namespace App\Repository;

use App\Entity\Param;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Interfaces\ParamRepositoryInterface;


class ParamRepository implements ParamRepositoryInterface
{

    private const ENTITY = Param::class;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * 
     * @var ObjectRepository
     */
    private $objectRepository;

     public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;  
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);
    }


    public function findAll()
    {
        return $this->objectRepository->findAll();
    }

      // /**
    //  * @return Param[] Returns an array of Param objects
    // */


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
    public function findOneBySomeField($value): ?Param
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
