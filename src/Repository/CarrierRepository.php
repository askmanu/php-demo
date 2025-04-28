<?php

/**
* This file defines the CarrierRepository class, which manages database operations for shipping carriers in the e-commerce platform. 
* 
* It extends Symfony's ServiceEntityRepository to provide standard data access methods for the Carrier entity. 
* 
* The repository enables the application to retrieve, create, update, and delete shipping carrier information, which is essential for the checkout process where customers select shipping methods. 
* While the file contains only the basic repository structure with commented example methods, it inherits functionality for finding carriers by ID, searching with custom criteria, and retrieving all available carriers.
*/

namespace App\Repository;

use App\Entity\Carrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carrier[]    findAll()
 * @method Carrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrierRepository extends ServiceEntityRepository
{
    /**
    * Constructor for the Carrier repository that initializes the repository with the Doctrine ManagerRegistry and sets Carrier as the entity class to manage.
    * 
    * @param ManagerRegistry registry The Doctrine registry that provides access to entity managers and connections
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carrier::class);
    }

    // /**
    //  * @return Carrier[] Returns an array of Carrier objects
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
    public function findOneBySomeField($value): ?Carrier
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
