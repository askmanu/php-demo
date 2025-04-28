<?php

/**
* This file defines the DashboardController for the La Boot'ique admin panel, built with EasyAdmin. 
* 
* It serves as the central hub for administrative functions, configuring the dashboard title and creating a navigation menu that provides access to manage all core e-commerce components. 
* 
* The controller redirects admin users to the order management interface by default and offers menu items for managing users, product categories, products, shipping carriers, orders, and website banners. 
* 
* Each menu item is associated with its corresponding entity and displays an appropriate Font Awesome icon for visual identification.
*/

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Headers;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /**
    * Default dashboard action that redirects to the Order management interface. This method serves as an entry point to the admin dashboard, automatically redirecting users to the order management section.
    * 
    * @return A Symfony Response object that redirects the user to the Order management interface.
    */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl());
    }

    /**
    * Configures the EasyAdmin dashboard by setting the title to "La Boot'Ique".
    * 
    * @return A Dashboard object configured with the application title.
    */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Boot\'Ique');

    }

    /**
    * Configures the menu items displayed in the Easy Admin dashboard for the e-commerce platform. Creates navigation links to manage various entities including users, categories, products, carriers, orders, and banners.
    * 
    * @return An iterable collection of MenuItem objects that define the admin dashboard's navigation menu structure.
    */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Bannières', 'fas fa-desktop', Headers::class);
    }
}
