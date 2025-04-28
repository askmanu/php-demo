<?php

/**
* This file defines the CarrierCrudController, which manages shipping carrier entities in the La Boot'ique e-commerce admin panel. 
* 
* Built with Symfony's EasyAdmin bundle, the controller provides a user interface for administrators to manage shipping options. 
* 
* It configures three editable fields: carrier name, description, and price (displayed in Euros). 
* 
* The controller also customizes the admin interface with French labels, displaying "Transporteur" for singular and "Transporteurs" for plural references. 
* 
* This component is essential for the store administrators to maintain shipping options available to customers during checkout.
*/

namespace App\Controller\Admin;

use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarrierCrudController extends AbstractCrudController
{
    /**
    * Returns the fully qualified class name (FQCN) of the Carrier entity managed by this CRUD controller.
    * 
    * @return string - The fully qualified class name of the Carrier entity.
    */
    public static function getEntityFqcn(): string
    {
        return Carrier::class;
    }

    /**
    * Configures the fields displayed in the EasyAdmin administration interface. Defines three fields for product management: a name field, description field, and price field with EUR currency.
    * 
    * @param string pageName Indicates which admin page is being configured (e.g., 'index', 'detail', 'edit', 'new')
    * 
    * @return An iterable collection of field objects that define the structure and properties of the form fields displayed in the admin interface.
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextareaField::new('description'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR')
        ];
    }

    /**
    * Configures the CRUD controller for the Transporteur (Carrier) entity by setting custom labels for singular and plural forms in the admin interface.
    * 
    * @param Crud crud The Crud configuration object that will be modified and returned
    * 
    * @return A configured Crud object with custom entity labels for the Transporteur entity
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Transporteur')
            ->setEntityLabelInPlural('Transporteurs')
        ;
    }

}
