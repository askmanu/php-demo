<?php

/**
* This file defines the UserCrudController, which manages user administration in the La Boot'ique e-commerce platform's admin panel. 
* 
* Built with EasyAdmin bundle for Symfony, it configures how user data is displayed and edited in the administration interface. 
* The controller specifies which user fields are visible (ID, email, roles, first name, and last name), customizes their display labels in French, and sets up entity naming conventions. 
* 
* It provides the structure for administrators to view and manage user accounts through a standardized interface, with certain fields strategically hidden depending on the context (form view vs. index view).
*/

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    /**
    * Returns the Fully Qualified Class Name (FQCN) of the User entity managed by this controller. This method is required by Easy Admin to identify which entity this controller is responsible for managing.
    * 
    * @return A string containing the Fully Qualified Class Name (FQCN) of the User entity.
    */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
    * Configures the fields to be displayed in the EasyAdmin interface for a user entity. Defines the visibility and display format of user properties like ID, email, roles, firstname, and lastname across different admin pages.
    * 
    * @param string pageName The current admin page context (e.g., 'index', 'detail', 'edit', 'new') that determines field visibility
    * 
    * @return An iterable collection of field objects that define the display properties for each entity attribute in the admin interface
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            ArrayField::new('roles', 'Rôle')->hideOnIndex(),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
        ];
    }

    /**
    * Configures the CRUD controller settings for the User entity by customizing the entity labels in the EasyAdmin administration interface.
    * 
    * @param Crud crud The Crud configuration object that will be modified and returned
    * 
    * @return A configured Crud object with customized entity labels for singular and plural forms
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateur')
        ;
    }
}
