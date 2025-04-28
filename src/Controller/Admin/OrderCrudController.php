<?php

/**
* This file defines the OrderCrudController, a Symfony controller that manages order administration in the La Boot'ique e-commerce platform's admin panel. 
* 
* It leverages EasyAdmin to create an interface for viewing and managing customer orders. 
* The controller customizes the admin experience by setting French labels, configuring available actions (removing the ability to create orders manually while adding detailed views), and establishing a default sort order showing newest orders first. 
* 
* It defines the display fields for orders including creation date, buyer information, total amount, shipping costs, and order status with four possible states (unpaid, paid, in preparation, and shipped). 
* 
* The controller provides administrators with the tools to track and update order status throughout the fulfillment process.
*/

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    /**
    * Returns the fully qualified class name (FQCN) of the Order entity managed by this CRUD controller.
    * 
    * @return string - The fully qualified class name of the Order entity.
    */
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    /**
    * Configures the available actions for an entity in the EasyAdmin administration panel. This method adds a 'detail' action to the index page and removes the 'new' action from the index page.
    * 
    * @param Actions actions The Actions object to configure
    * 
    * @return The configured Actions object with the applied modifications
    */
    public function configureActions(Actions $actions): Actions 
    {
        return $actions
            ->add('index', 'detail')
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ;
    }

    /**
    * Configures the CRUD interface settings for the Order entity in the admin panel, setting display labels and default sorting order.
    * 
    * @param Crud crud The Crud configuration object to be modified
    * 
    * @return A configured Crud object with entity labels set to 'Commande'/'Commandes' and default sorting by ID in descending order
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
            ->setDefaultSort(['id' => 'DESC']);
    }
    
    /**
    * Configures the fields displayed in the EasyAdmin interface for order management. Defines visible and editable fields including order ID, creation date, buyer information, pricing details, order status, and purchased products.
    * 
    * @param string pageName The context name indicating which page is being configured (e.g., 'index', 'detail', 'form', etc.)
    * 
    * @return An iterable collection of field objects that define the structure and behavior of the order management interface.
    */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt', 'Créée le'),
            TextField::new('user.fullname', 'Acheteur'),
            MoneyField::new('total')->setCurrency('EUR')->hideOnForm(),
            MoneyField::new('carrierPrice', 'Frais livraison')->setCurrency('EUR'),
            ChoiceField::new('state', 'Etat')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Expédiée' => 3,
            ]
            ),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()->hideOnForm()
        ];
    }

}
