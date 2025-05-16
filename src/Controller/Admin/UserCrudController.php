<?php

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
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     * Configures and returns the field definitions for entity forms and listings. This method defines the structure and behavior of fields that will be displayed in the user interface.
     *
     * @param string $pageName The name of the page or context where these field configurations will be applied
     * 
     * @return An iterable array of field objects that define the structure and behavior of form fields, including ID, email, roles, first name, and last name fields with specific display configurations.
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateur')
        ;
    }
}
