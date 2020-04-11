<?php

namespace App\Repository;

use App\Entity\Ordertable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ordertable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordertable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordertable[]    findAll()
 * @method Ordertable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdertableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordertable::class);
    }

    // /**
    //  * @return Ordertable[] Returns an array of Ordertable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ordertable
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
