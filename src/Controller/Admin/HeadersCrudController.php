<?php

namespace App\Controller\Admin;

use App\Entity\Headers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeadersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Headers::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bannière')
            ->setEntityLabelInPlural('Bannières')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
    
    
    /**
     * Configures and returns the form fields to be displayed on a page. This includes text fields for title, button title and URL, a textarea for content, and an image field with upload settings.
     *
     * @param string $pageName The name of the page for which to configure fields
     * 
     * @return An iterable collection of field objects that define the form structure, including text fields, textarea, and image upload field with configured paths and naming pattern.
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
