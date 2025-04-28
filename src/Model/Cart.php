<?php

/**
* The Cart class is a model component that manages shopping cart functionality for the La Boot'ique e-commerce platform. 
* 
* It provides a session-based implementation that stores product IDs and their quantities, abstracting cart operations away from controllers. 
* 
* The class offers methods to add products to the cart, retrieve cart contents, remove items individually or clear the entire cart, and decrease product quantities. 
* It also includes functionality to generate detailed cart information by fetching product data from the database and calculating totals for both quantity and price. 
* 
* This component serves as the core shopping cart management system for the application, handling all cart-related state and operations through the user's session.
*/

namespace App\Model;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Permet de gérer un panier en session plutot que de tout implémenter dans le controller
 */
class Cart 
{
    private $session;

    /**
    * Initializes a new instance of the class with session management and product repository dependencies.
    * 
    * @param SessionInterface session The session service for managing user session data
    * @param ProductRepository repository Repository for accessing and managing product data
    */
    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }


    /**
    * Adds a product to the shopping cart or increments its quantity if already present. The cart is stored in the session.
    * 
    * @param int id The ID of the product to add to the cart
    */
    public function add(int $id):void
    {
        $cart = $this->session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $this->session->set('cart', $cart);

    }

    /**
    * Retrieves the current cart data from the session.
    * 
    * @return An array containing the current cart items and their data stored in the session.
    */
    public function get(): array
    {
        return $this->session->get('cart');
    }


    /**
    * Removes the shopping cart data from the current session, effectively emptying the cart.
    */
    public function remove(): void
    {
        $this->session->remove('cart');
    }


    /**
    * Removes a specific item from the shopping cart by its ID.
    * 
    * @param int id The ID of the product to remove from the cart
    */
    public function removeItem(int $id): void
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        $this->session->set('cart', $cart);
    }


    /**
    * Decreases the quantity of a specified item in the shopping cart by one. If the item's quantity becomes less than 2, the item is completely removed from the cart.
    * 
    * @param int $id The ID of the product to decrease in quantity
    */
    public function decreaseItem(int $id): void
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] < 2) {
            unset($cart[$id]);
        } else {
            $cart[$id]--;
        }
        $this->session->set('cart', $cart);
    }


    /**
    * Retrieves the current shopping cart details, including products, quantities, and calculated totals. This method processes the cart data stored in the session and enriches it with product information from the database.
    * 
    * @return An array containing the cart details with the following structure:
    - 'products': An array of items in the cart, each containing 'product' object and 'quantity'
    - 'totals': An array with 'quantity' (total number of items) and 'price' (total cart value)
    */
    public function getDetails(): array
    {
        $cartProducts = [
            'products' => [],
            'totals' => [
                'quantity' => 0,
                'price' => 0,
            ],
        ];

        $cart = $this->session->get('cart', []);
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $currentProduct = $this->repository->find($id);
                if ($currentProduct) {
                    $cartProducts['products'][] = [
                        'product' => $currentProduct,
                        'quantity' => $quantity
                    ];
                    $cartProducts['totals']['quantity'] += $quantity;
                    $cartProducts['totals']['price'] += $quantity * $currentProduct->getPrice();
                }
            }
        }
        return $cartProducts;
    }
}