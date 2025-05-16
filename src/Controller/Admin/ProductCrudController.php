<?php

/**
* This file defines the ProductCrudController, which manages product administration in the La Boot'ique e-commerce platform's admin panel. 
* 
* Built with EasyAdmin, it provides a comprehensive interface for managing product entities with customized fields including product name, slug, image upload capabilities, subtitle, description, price in Euros, category association, and a toggle for featuring products on the homepage. 
* 
* The controller customizes the admin experience by adding a detail view option to the product listing page and translates interface labels to French. 
* This controller serves as the central management point for all product-related operations in the admin backend.
*/

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    /**
    * Returns the fully qualified class name (FQCN) of the Product entity managed by this CRUD controller.
    * 
    * @return A string containing the fully qualified class name of the Product entity.
    */
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    /**
    * Configures the actions available in the admin interface by adding a 'detail' action to the 'index' page.
    * 
    * @param Actions actions The Actions object that will be configured with additional actions
    * 
    * @return Actions object with the configured actions
    */
    public function configureActions(Actions $actions): Actions 
    {
        return $actions
            ->add('index', 'detail')
            ;
    }

    /**
    * Configures the fields to be displayed in the EasyAdmin interface for a product entity, including text fields, image upload, price formatting, category association, and boolean options.
    * 
    * @param string pageName The name of the current admin page context (e.g., 'index', 'detail', 'edit', 'new')
    * 
    * @return An iterable array of field objects that define the structure and behavior of form fields in the EasyAdmin interface.
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Nom'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('image')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('subtitle', 'Sous-titre'),
            TextareaField::new('description')->hideOnIndex(),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            AssociationField::new('category', 'Catégorie'),
            BooleanField::new('isInHome', 'Top produit')
        ];
    }
    
    /**
    * Configures the CRUD controller settings for the product entity, setting custom singular and plural labels in French.
    * 
    * @param Crud crud The CRUD configuration object to be modified
    * 
    * @return A configured Crud object with customized entity labels
    */    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
        ;
    }

}
