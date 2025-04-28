<?php

/**
* This controller manages the order processing workflow in the La Boot'ique e-commerce platform. It handles two primary functions: displaying the order form and processing order submissions. 
* 
* The controller first validates that users have products in their cart and a delivery address before allowing them to proceed with checkout. When an order is submitted, it creates a new order record with customer information, selected shipping method, and a unique reference number. 
* 
* It then processes each item in the shopping cart into order line items, calculating totals and storing product details. 
* The controller integrates with Symfony's form handling system and the application's cart service to manage the transition from shopping cart to confirmed order, ultimately persisting the complete order data to the database and displaying an order confirmation page to the customer.
*/


namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Model\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
    * Handles the order creation process by checking cart contents and user address availability before displaying the order form. Redirects to appropriate pages if prerequisites are not met.
    * 
    * @param SessionInterface session The session service for storing and retrieving session data
    * @param Cart cart The cart service for retrieving cart details
    * 
    * @return Response object containing either a redirect to another page or the rendered order form template
    */
    #[Route('/commande', name: 'order')]
    public function index(SessionInterface $session, Cart $cart): Response
    {
        $user = $this->getUser();
        $cartProducts = $cart->getDetails();

        // Redirection si panier vide
        if (empty($cartProducts['products'])) {   
            return $this->redirectToRoute('product');
        }
        
        if (!$user->getAddresses()->getValues()) {
            $session->set('order', 1);
            return $this->redirectToRoute('account_address_new');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $user 
        ]); 

        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'cart' => $cartProducts,
            'totalPrice' =>$cartProducts['totals']['price']
        ]);
    }

    /**
    * Processes the order submission form, creates a new order with the selected delivery address and carrier, and saves all order details to the database. If successful, displays the order confirmation page; otherwise redirects to the cart page.
    * 
    * @param Cart cart Service that provides access to the user's shopping cart contents
    * @param Request request The HTTP request object containing form submission data
    * @param EntityManagerInterface em Doctrine entity manager for database operations
    * 
    * @return Response object containing either the order confirmation page or a redirect to the cart page
    */
    #[Route('/commande/recap', name: 'order_add', methods: 'POST')]
    public function summary(Cart $cart, Request $request, EntityManagerInterface $em): Response
    {
        $cartProducts = $cart->getDetails();   

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()     
        ]); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->get('addresses')->getData();

            $delivery_string = $address->getFirstname() . ' ' . $address->getLastname();
            $delivery_string .= '<br>' . $address->getPhone();
            $delivery_string .= '<br>' . $address->getCompany() ?? '';
            $delivery_string .= '<br>' . $address->getAddress();
            $delivery_string .= '<br>' . $address->getPostal();
            $delivery_string .= '<br>' . $address->getCity();
            $delivery_string .= '<br>' . $address->getCountry();

            $cartProducts = $cart->getDetails();

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
            $em->persist($order);

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
            $em->flush();

            return $this->renderForm('order/add.html.twig', [
                'cart' => $cartProducts,
                'totalPrice' =>$cartProducts['totals']['price'],
                'order' => $order
            ]);
        }
        return $this->redirectToRoute('cart');
    }
}
