Checkout Process and Order Creation
==================================

When a user is ready to complete their purchase, the cart data must be transformed into a permanent order record. This critical process involves several steps to ensure data integrity and proper order management.

Initiating the Checkout Process
-------------------------------

The checkout process begins when a user navigates to the checkout page. Before displaying the checkout form, the system performs several important validations:

.. code-block:: php

    // Check if cart is empty
    if (empty($cartProducts['products'])) {   
        return $this->redirectToRoute('product');
    }
    
    // Check if user has a delivery address
    if (!$user->getAddresses()->getValues()) {
        $session->set('order', 1);
        return $this->redirectToRoute('account_address_new');
    }

These validations ensure that:

1. The user has items in their cart
2. The user has at least one delivery address available

If either condition fails, the user is redirected to the appropriate page to resolve the issue before proceeding.

Address Selection and Shipping Options
--------------------------------------

Once validations pass, the checkout form is presented to the user. This form typically includes:

- Selection of a delivery address from the user's saved addresses
- Choice of shipping method/carrier
- Summary of cart contents and total price

The form is created using Symfony's form system, with options customized for the current user:

.. code-block:: php

    $form = $this->createForm(OrderType::class, null, [
        'user' => $user 
    ]);

Order Creation Process
----------------------

When the user submits the checkout form, the system processes the form data and creates a permanent order record:

1. The selected address is formatted into a delivery string
2. A new Order entity is created with:
   - Reference to the user
   - Creation timestamp
   - Selected carrier name and price
   - Formatted delivery address
   - Initial state (typically "pending")
   - Unique order reference number

.. code-block:: php

    $order = new Order;
    $date = new \DateTime;
    $order
        ->setUser($this->getUser())
        ->setCreatedAt($date)
        ->setCarrierName($form->get('carriers')->getData()->getName())
        ->setCarrierPrice($form->get('carriers')->getData()->getPrice())
        ->setDelivery($delivery_string)
        ->setState(0)
        ->setReference($date->format('YmdHis') . '-' . uniqid())
    ;

Converting Cart Items to Order Details
--------------------------------------

Each item in the cart is then converted into an OrderDetails entity, which is linked to the main order:

.. code-block:: php

    foreach ($cartProducts['products'] as $item) {
        $orderDetails = new OrderDetails();
        $orderDetails
            ->setBindedOrder($order)
            ->setProduct($item['product']->getName())
            ->setQuantity($item['quantity'])
            ->setPrice($item['product']->getPrice())
            ->setTotal($item['product']->getPrice() * $item['quantity'])
        ;
        $em->persist($orderDetails);
    }

This process captures the current state of each product, including:
- Product name
- Quantity ordered
- Current price
- Line item total

By storing this information directly in the order details, the system ensures that future changes to product prices won't affect existing orders.

Finalizing the Order
-------------------

Once all order details are created, the entire transaction is persisted to the database:

.. code-block:: php

    $em->flush();

The user is then presented with an order confirmation page showing the order details and next steps, which typically include proceeding to payment processing.

This transformation from temporary cart data to a permanent order record is a critical step in the e-commerce flow, creating the foundation for subsequent processes like payment, fulfillment, and order tracking.