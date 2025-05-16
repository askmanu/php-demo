<?php

/**
* This file defines an admin controller for managing website banners in the La Boot'ique e-commerce platform. 
* 
* The HeadersCrudController extends EasyAdmin's AbstractCrudController to provide a user interface for creating, editing, and deleting banner elements. 
* 
* It configures the admin interface with French labels ("Bannière"/"Bannières") and sets up form fields for banner management, including title, content text, button properties (title and URL), and image uploads. 
* 
* The controller handles image storage with randomized filenames and proper directory configuration, enabling administrators to maintain promotional banners that appear on the storefront.
*/

namespace App\Controller\Admin;

use App\Entity\Headers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeadersCrudController extends AbstractCrudController
{   
    /**
    * Returns the fully qualified class name (FQCN) of the Headers entity managed by this CRUD controller.
    * 
    * @return A string containing the fully qualified class name of the Headers entity.
    */
    public static function getEntityFqcn(): string
    {
        return Headers::class;
    }

    /**
    * Configures the CRUD controller settings for the Banner entity in the admin panel, setting display labels and default sorting order.
    * 
    * @param Crud crud The Crud configuration object to be modified
    * 
    * @return Crud object with configured entity labels and default sorting
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bannière')
            ->setEntityLabelInPlural('Bannières')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
    
    /**
    * Configures the fields displayed in the EasyAdmin interface for this entity. Defines text fields for title, content, button title and URL, plus an image field with upload configuration.
    * 
    * @param string $pageName The current admin page context (e.g., 'index', 'detail', 'edit', 'new')
    * 
    * @return An iterable array of field objects that define the display and editing options for the entity's properties in the admin interface
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            TextareaField::new('content', 'Contenu'),
            TextField::new('btnTitle', 'Titre bouton'),
            TextField::new('btnUrl', 'Url bouton'),
            ImageField::new('image')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }
    
}
