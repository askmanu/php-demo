Cart Display and User Interaction
=================================

Retrieving Cart Contents
------------------------

When a user views their shopping cart, the e-commerce system needs to retrieve the current cart contents from storage and present them in a user-friendly format. In our example application, this process is handled by the ``CartController`` class, specifically in its ``index()`` method:

.. code-block:: php

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

The controller uses a ``Cart`` service that encapsulates the logic for retrieving cart data from the session storage. The ``getDetails()`` method returns a structured array containing both the cart items and calculated totals.

Calculating Cart Totals
-----------------------

The cart system must calculate several important values:

1. **Item subtotals**: The price of each product multiplied by its quantity
2. **Cart total quantity**: The sum of all item quantities
3. **Cart total price**: The sum of all item subtotals

These calculations are typically performed by the Cart service and returned in the ``totals`` section of the cart details array. This separation of concerns keeps the controller focused on routing and rendering, while the business logic remains in the service layer.

Interactive Elements
--------------------

The cart interface provides several interactive elements to allow users to modify their cart contents:

1. **Add items**: Increase the quantity of a product in the cart
   
   .. code-block:: php
   
       #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
       public function add(Cart $cart, int $id): Response
       {
           $cart->add($id);
           return $this->redirectToRoute('cart');
       }

2. **Decrease items**: Reduce the quantity of a product by one
   
   .. code-block:: php
   
       #[Route('/panier/réduire/{id}', name: 'decrease_item')]
       public function decrease(Cart $cart, int $id): Response
       {
           $cart->decreaseItem($id);
           return $this->redirectToRoute('cart');
       }

3. **Remove specific items**: Delete a product entirely from the cart
   
   .. code-block:: php
   
       #[Route('/panier/supprimer/{id}', name: 'remove_cart_item')]
       public function removeItem(Cart $cart, int $id): Response
       {
           $cart->removeItem($id);
           return $this->redirectToRoute('cart');
       }

4. **Empty the cart**: Remove all items from the cart
   
   .. code-block:: php
   
       #[Route('/panier/supprimer/', name: 'remove_cart')]
       public function remove(Cart $cart): Response
       {
           $cart->remove();
           return $this->redirectToRoute('product');
       }

Each of these actions is implemented as a separate controller method with its own route, allowing users to interact with their cart through links or buttons in the interface.

Rendering the Cart Display
--------------------------

Finally, the cart data is passed to a Twig template (``cart/index.html.twig``) which renders the information in a user-friendly format. The template typically includes:

1. A list of cart items with product details, quantities, and prices
2. Subtotal for each line item
3. Cart summary showing total quantity and price
4. Buttons or links for the interactive elements (add, decrease, remove)
5. A checkout button to proceed to the next step in the purchasing process

This separation between data retrieval, calculation, and presentation follows the MVC (Model-View-Controller) pattern, making the code more maintainable and easier to extend.
