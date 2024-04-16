<?php

namespace App\Repository;

use App\Entity\Loginaso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loginaso>
 *
 * @method Loginaso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loginaso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loginaso[]    findAll()
 * @method Loginaso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginasoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loginaso::class);
    }

    //    /**
    //     * @return Loginaso[] Returns an array of Loginaso objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Loginaso
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
