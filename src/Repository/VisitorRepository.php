<?php

namespace App\Repository;

use App\Entity\Visitor;
use Doctrine\ORM\EntityManagerInterface;
use App\Interfaces\VisitorRepositoryInterface;



class VisitorRepository implements VisitorRepositoryInterface
{

    private const ENTITY = Visitor::class;

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



    public function find($visitor): ?Visitor
    {
        $this->entityManager->find(self::ENTITY, $id->toString());
    }


    public function save($visitor): void
    {
        $this->entityManager->persist($visitor);
        // $this->entityManager->flush();
    }

    public function remove($visitor): void
    {
        $this->entityManager->remove($visitor);
    }
}
