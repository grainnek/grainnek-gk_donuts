<?php

namespace App\Repository;

use App\Entity\CustomerDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerDetails[]    findAll()
 * @method CustomerDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerDetails::class);
    }

    // /**
    //  * @return CustomerDetails[] Returns an array of CustomerDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomerDetails
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
