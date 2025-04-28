<?php

/**
* This file defines the CategoryRepository class, which is responsible for database operations related to product categories in the La Boot'ique e-commerce platform. 
* 
* Built on Symfony's Doctrine ORM, it extends ServiceEntityRepository to provide standard data access methods for retrieving category information from the database. 
* The repository supports finding categories by ID, retrieving all categories, and querying categories based on specific criteria. 
* 
* While the file includes commented template code for custom query methods, it currently relies on the inherited functionality from the parent repository class. 
* 
* This repository serves as the data access layer for category management throughout the application.
*/

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{   
    /**
    * Constructor for the Category repository that initializes the repository with the Doctrine registry and sets Category as the entity class to manage.
    * 
    * @param ManagerRegistry registry The Doctrine registry that provides access to entity managers and connections
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
