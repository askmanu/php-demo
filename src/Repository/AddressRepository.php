<?php

/**
* This file defines the AddressRepository class, which manages database operations for customer addresses in the La Boot'ique e-commerce platform. 
* 
* Built on Symfony's Doctrine ORM, it extends ServiceEntityRepository to provide standard data access methods for the Address entity. 
* 
* The repository enables the application to retrieve, create, update, and delete address records in the database. 
* 
* While it currently implements only the basic repository functionality, it includes commented template code for potential custom query methods that could be implemented as needed.
*/

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    /**
    * Constructor for the Address repository that initializes the repository with the Doctrine registry and sets Address as the managed entity.
    * 
    * @param ManagerRegistry registry The Doctrine registry that provides access to entity managers
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
