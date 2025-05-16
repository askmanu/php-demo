<?php
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
     * @param SessionInterface session The session management interface for handling user sessions
     * @param ProductRepository repository The repository for accessing and managing product data
     */
    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }


    /**
     * Adds an item to the shopping cart or increments its quantity if it already exists in the cart.
     *
     * @param int $id The identifier of the item to add to the cart
     * 
     * @return void
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
     * Récupère le panier en session
     *
     * @return array
     */
    public function get(): array
    {
        return $this->session->get('cart');
    }


    /**
     * Supprime entièrement le panier en session
     *
     * @return void
     */
    public function remove(): void
    {
        $this->session->remove('cart');
    }


    /**
     * Supprime entièrement un produit du panier (quelque soit sa quantité)
     *
     * @param int $id
     * @return void
     */
    public function removeItem(int $id): void
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        $this->session->set('cart', $cart);
    }


    /**
     * Decreases the quantity of an item in the cart by one. If the quantity becomes less than 2, the item is removed from the cart entirely.
     *
     * @param int id The identifier of the item to decrease in the cart
     * 
     * @return void - This method doesn't return a value
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
     * Retrieves the current shopping cart details including products, quantities, and calculated totals. The method fetches cart data from the session, looks up complete product information from the repository, and calculates the total quantity and price.
     * 
     * @return An array containing the complete cart information with the following structure: 'products' (array of product objects with their quantities) and 'totals' (containing the sum of quantities and the total price).
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