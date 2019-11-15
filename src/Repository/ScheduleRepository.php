<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Interfaces\ScheduleRepositoryInterface;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository implements ScheduleRepositoryInterface
{

    private const ENTITY= Schedule::class;
    private $entityManager;
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
}
