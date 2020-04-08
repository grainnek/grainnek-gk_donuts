<?php

namespace App\Repository;

use App\Entity\CustDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustDetails[]    findAll()
 * @method CustDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustDetails::class);
    }

    // /**
    //  * @return CustDetails[] Returns an array of CustDetails objects
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
    public function findOneBySomeField($value): ?CustDetails
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
