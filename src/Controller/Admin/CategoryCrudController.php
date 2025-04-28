<?php

/**
* This file defines the CategoryCrudController, an administrative controller that manages product categories in the La Boot'ique e-commerce platform. 
* 
* Built with Symfony and EasyAdmin, it provides the backend functionality for creating, reading, updating, and deleting product categories. 
* 
* The controller customizes the admin interface by setting French language labels ("Catégorie" and "Catégories") and configures the form to display only the category name field. 
* 
* This controller is a key component of the product organization system, enabling administrators to maintain the category structure used throughout the store.
*/

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    /**
    * Configures the CRUD interface for the Category entity by setting custom labels for singular and plural forms in French.
    * 
    * @param Crud crud The Crud configuration object that will be modified and returned
    * 
    * @return A configured Crud object with custom entity labels for singular and plural forms
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
        ;
    }

    /**
    * Configures the fields to be displayed in the Easy Admin interface. Currently set up to show only a name field with the label 'Nom'.
    * 
    * @param string pageName The context where the fields will be used (e.g., 'index', 'detail', 'edit', 'new')
    * 
    * @return An iterable collection of field objects that define the structure and behavior of the admin interface form fields.
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
        ];
    }
}
