<?php

/**
* This file contains the CartController for the La Boot'ique e-commerce platform, which manages all shopping cart functionality. 
* 
* The controller provides endpoints for viewing the cart contents, adding products, decreasing item quantities, removing specific items, and emptying the entire cart. 
* 
* It leverages Symfony's routing system with French-language URLs and works with a Cart service that handles the underlying business logic. 
* 
* The controller renders cart information to users, including product details, total quantity, and total price, through a Twig template. 
* 
* This component is essential for the e-commerce platform's shopping experience, allowing customers to manage their selected products before proceeding to checkout.
*/

namespace App\Controller;

use App\Model\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
    * Renders the shopping cart page displaying the products in the cart, total quantity, and total price.
    * 
    * @param Cart cart Service that manages the shopping cart functionality and provides access to cart details
    * 
    * @return Response object containing the rendered cart page with products, quantities, and prices
    */
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cartProducts = $cart->getDetails();

        return $this->render('cart/index.html.twig', [
            'cart' => $cartProducts['products'],
            'totalQuantity' => $cartProducts['totals']['quantity'],
            'totalPrice' =>$cartProducts['totals']['price']
        ]);
    }

    /**
    * Adds a product to the shopping cart and redirects to the cart page.
    * 
    * @param Cart cart The cart service that manages shopping cart functionality
    * @param int id The ID of the product to add to the cart
    * 
    * @return A Response object that redirects to the cart page
    */
    #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
    * Decreases the quantity of a specific item in the shopping cart by one unit and redirects to the cart page.
    * 
    * @param Cart cart The cart service that manages shopping cart operations
    * @param int id The identifier of the cart item to decrease
    * 
    * @return A Response object that redirects to the cart page
    */
    #[Route('/panier/réduire/{id}', name: 'decrease_item')]
    public function decrease(Cart $cart, int $id): Response
    {
        $cart->decreaseItem($id);
        return $this->redirectToRoute('cart');
    }

    /**
    * Removes an item from the shopping cart and redirects to the cart page.
    * 
    * @param Cart cart The shopping cart service instance
    * @param int id The ID of the item to remove from the cart
    * 
    * @return Response object that redirects to the cart page
    */
    #[Route('/panier/supprimer/{id}', name: 'remove_cart_item')]
    public function removeItem(Cart $cart, int $id): Response
    {
        $cart->removeItem($id);
        return $this->redirectToRoute('cart');
    }

    /**
    * Removes all items from the shopping cart and redirects to the product listing page.
    * 
    * @param Cart cart The shopping cart service that manages cart operations
    * 
    * @return A Response object that redirects to the product listing page
    */
    #[Route('/panier/supprimer/', name: 'remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('product');
    }
}
