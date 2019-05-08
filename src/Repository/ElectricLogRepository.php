<?php

namespace App\Repository;

use App\Entity\ElectricLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ElectricLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectricLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectricLog[]    findAll()
 * @method ElectricLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectricLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ElectricLog::class);
    }

    // /**
    //  * @return ElectricLog[] Returns an array of ElectricLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElectricLog
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
