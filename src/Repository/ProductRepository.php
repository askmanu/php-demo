<?php

/**
* This file defines the ProductRepository class, which handles database operations for products in the La Boot'ique e-commerce platform. 
* 
* It extends Symfony's ServiceEntityRepository to provide standard data access methods for Product entities. 
* 
* The repository includes a custom search function that enables filtering products by categories and/or keywords, supporting the platform's product search functionality. 
* 
* The implementation uses Doctrine's QueryBuilder to construct efficient database queries that join product data with their associated categories, allowing for complex filtering based on user search criteria.
*/

namespace App\Repository;

use App\Entity\Product;
use App\Model\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
    * Constructor for the Product repository that initializes the repository with the Doctrine registry and sets Product as the managed entity class.
    * 
    * @param ManagerRegistry registry The Doctrine registry that provides access to entity managers
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * Retrieves products from the database based on search criteria. Filters products by category and/or name according to the provided Search object parameters.
    * 
    * @param Search search A Search object containing filtering criteria such as categories and search string
    * 
    * @return An array of Product entities that match the specified search criteria, with their associated categories.
    */
    public function findWithSearch(Search $search): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c')
        ;
        if (!empty($search->getCategories())) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->getCategories())
            ;    
        }

        if (!empty($search->getString())) {
            $query = $query
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$search->getString()}%")
            ;    
        }

        return $query->getQuery()->getResult();
        
    }

}
