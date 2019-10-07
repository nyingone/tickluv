<?php

namespace App\Repository;

use App\Entity\ClosingPeriod;
use App\Interfaces\ClosingPeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


final class ClosingPeriodRepository implements ClosingPeriodRepositoryInterface
{
    private const ENTITY = ClosingPeriod::class;

    /**
     * Undocumented variable
     *
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $objectRepository;

    
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);
    }


    /**
     * Undocumented function
     *
     * @return array
     */
    public function findAllClosedPeriod()
    {
        return $this->objectRepository->findAll();
       
    }
  
}
