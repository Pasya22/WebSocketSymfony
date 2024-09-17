<?php

namespace App\Repository;

use App\Entity\DataRealtime;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataRealtime>
 *
 * @method DataRealtime|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataRealtime|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataRealtime[]    findAll()
 * @method DataRealtime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataRealtimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataRealtime::class);
    }

    public function findAllMessages(): array
    {
        return $this->findAll();
    }
}
