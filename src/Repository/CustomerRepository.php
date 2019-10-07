<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use App\Interfaces\CustomerRepositoryInterface;


class CustomerRepository implements CustomerRepositoryInterface
{

    private const ENTITY = Customer::class;
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

    public function find($id): ?Customer
    {
        $this->entityManager->find(self::ENTITY, $id->toString());
    }

    public function findOneByEmail(string $email): ?Customer
    {
        return $this->objectRepository->findOneBy(['email' => $email]);
    }

    public function save(Customer $customer): void
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function remove(Customer $customer): void
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}