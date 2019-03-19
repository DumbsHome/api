<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\Log;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Log::class);
    }

    /**
     * @param User $user
     * @return Log[]
     */
    public function findByUser(User $user)
    {
        return $this
            ->createQueryBuilder('l')
            ->leftJoin(
                Device::class,
                'd',
                Join::WITH,
                'l.device = d.id'
            )
            ->leftJoin(
                User::class,
                'u',
                Join::WITH,
                'd.user = :user_id'
            )
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->execute();
    }
}
