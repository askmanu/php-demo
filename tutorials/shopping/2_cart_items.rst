Adding and Modifying Cart Items
===============================

The heart of any e-commerce system lies in its ability to manage cart items efficiently. Let's examine how products are added, modified, and removed from a shopping cart.

Cart Item Management Architecture
---------------------------------

In our e-commerce implementation, cart management is handled through a dedicated ``CartController`` class that works with a ``Cart`` service. This separation of concerns follows best practices by keeping the controller focused on handling HTTP requests while delegating business logic to the service layer.

The controller provides several endpoints for cart operations:

.. code-block:: php

    #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
    #[Route('/panier/réduire/{id}', name: 'decrease_item')]
    #[Route('/panier/supprimer/{id}', name: 'remove_cart_item')]
    #[Route('/panier/supprimer/', name: 'remove_cart')]

Adding Products to Cart
-----------------------

When a user clicks "Add to Cart," the system processes this request through the ``add()`` method in the ``CartController``:

.. code-block:: php

    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

This method receives the product ID as a parameter and passes it to the Cart service's ``add()`` method. The service is responsible for:

1. Retrieving the product information from the database
2. Creating or updating the cart item in the session storage
3. Maintaining the relationship between the product and its quantity in the cart

Updating Quantities
-------------------

The system provides a way to decrease quantities through the ``decrease_item`` route. This is handled by the ``decreaseItem()`` method in the Cart service:

.. code-block:: php

    public function decrease(Cart $cart, int $id): Response
    {
        $cart->decreaseItem($id);
        return $this->redirectToRoute('cart');
    }

This method intelligently manages quantity updates by:

1. Decreasing the quantity by one if more than one item exists
2. Completely removing the item if only one remains
3. Ensuring data integrity by validating the product ID

Removing Items
--------------

Users can remove specific items or clear the entire cart:

.. code-block:: php

    public function removeItem(Cart $cart, int $id): Response
    {
        $cart->removeItem($id);
        return $this->redirectToRoute('cart');
    }

    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('product');
    }

The ``removeItem()`` method targets a specific product, while ``remove()`` clears the entire cart. After removing all items, the user is redirected to the product listing page to continue shopping.

Data Integrity Considerations
-----------------------------

Throughout these operations, the system maintains data integrity by:

1. Validating product IDs before performing operations
2. Using session storage to persist cart data between page loads
3. Recalculating totals after each modification
4. Ensuring consistent state between the cart and available products

This architecture provides a robust foundation for managing cart items while maintaining a clean separation between the controller layer that handles HTTP requests and the service layer that contains the business logic.