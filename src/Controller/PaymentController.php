<?php

/**
* This controller manages the payment processing flow for the e-commerce platform. It handles the creation of Stripe checkout sessions, processes successful payments, and manages failed payment attempts. 
* 
* The controller retrieves order information, formats it for Stripe's API including product details and shipping costs, and redirects users to Stripe's payment interface. Upon successful payment, it updates the order status, sends a confirmation email to the customer, and clears their shopping cart. 
* 
* The controller includes security measures to verify that users can only access their own orders and provides appropriate feedback through dedicated success and failure pages. 
* 
* It serves as the critical link between the application's order system and the Stripe payment gateway.
*/

namespace App\Controller;

use App\Entity\Order;
use App\Model\Cart;
use App\Repository\OrderRepository;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
    * Initiates the Stripe payment process for an order. Retrieves the order by reference, formats the order items and shipping cost for Stripe's API, creates a Stripe checkout session, and redirects the user to the Stripe payment page.
    * 
    * @param OrderRepository repository Repository used to find the order by its reference
    * @param string reference The unique reference identifier for the order
    * @param EntityManagerInterface em Entity manager used to persist changes to the order
    * 
    * @return Response object that redirects the user to the Stripe checkout page
    * 
    * @throws NotFoundHttpException if the order with the given reference does not exist
    */
    #[Route('/commande/checkout/{reference}', name: 'checkout')]
    public function payment(OrderRepository $repository, $reference, EntityManagerInterface $em): Response
    {
        $order = $repository->findOneByReference($reference);
        if (!$order) {
            throw $this->createNotFoundException('Cette commande n\'existe pas');
        }
        $products = $order->getOrderDetails()->getValues();
        $productsForStripe = [];
        foreach ($products as $item) {
            $productsForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()
                    ]
                ],
                'quantity' => $item->getQuantity()
            ];
        }

        $productsForStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName()
                ]
            ],
            'quantity' => 1
        ];
        Stripe::setApiKey('sk_test_51Kb6uhClAQQ2TXfzOspWIks7VFbXX5e5ZTr5c4VCIQfNJATKvQZDHBODlaDkCnNmYntKUQLZK8YF4UbNPA5gMWzg00RHLAzE0G');
        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'https://ecommerce.tristan-bonnal.fr';
        
        // Création de la session Stripe avec les données du panier
        $checkout_session = Session::create([
            'line_items' => $productsForStripe,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/valide/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/echec/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeSession($checkout_session->id);
        $em->flush();
        return $this->redirect($checkout_session->url);
    }

    /**
    * Processes a successful payment by validating the order, updating its state, sending a confirmation email to the customer, clearing their cart, and displaying a success page.
    * 
    * @param OrderRepository repository Repository used to find the order by Stripe session ID
    * @param string stripeSession The Stripe session ID from the URL parameter
    * @param EntityManagerInterface em Entity manager for persisting changes to the database
    * @param Cart cart Cart service used to clear the user's cart after successful payment
    * 
    * @return A Response object containing the rendered success.html.twig template with the order data
    * 
    * @throws NotFoundHttpException if the order is not found or doesn't belong to the current user
    */
    #[Route('/commande/valide/{stripeSession}', name: 'payment_success')]
    public function paymentSuccess(OrderRepository $repository, $stripeSession, EntityManagerInterface $em, Cart $cart) 
    {
        $order = $repository->findOneByStripeSession($stripeSession);
        if (!$order || $order->getUser() != $this->getUser()) {
            throw $this->createNotFoundException('Commande innaccessible');
        }
        if (!$order->getState()) {
            $order->setState(1);
            $em->flush();
        }

        $user = $this->getUser();

        $content = "Bonjour {$user->getFirstname()} nous vous remercions de votre commande";
        (new Mail)->send(
            $user->getEmail(), 
            $user->getFirstname(), 
            "Confirmation de la commande {$order->getReference()}", 
            $content
        );

        $cart->remove();    
        return $this->render('payment/success.html.twig', [
            'order' => $order
        ]);
    }

    /**
    * Handles payment failure scenarios by retrieving the associated order and rendering a failure page. Validates that the order exists and belongs to the current user before displaying the failure template.
    * 
    * @param OrderRepository repository Repository used to retrieve order information from the database
    * @param string stripeSession The Stripe session identifier used to locate the corresponding order
    * 
    * @return A Response object containing the rendered 'payment/fail.html.twig' template with the order information
    * 
    * @throws NotFoundHttpException when the order doesn't exist or doesn't belong to the current user
    */
    #[Route('/commande/echec/{stripeSession}', name: 'payment_fail')]
    public function paymentFail(OrderRepository $repository, $stripeSession) 
    {
        $order = $repository->findOneByStripeSession($stripeSession);
        if (!$order || $order->getUser() != $this->getUser()) {
            throw $this->createNotFoundException('Commande innaccessible');
        }

        return $this->render('payment/fail.html.twig', [
            'order' => $order
        ]);
    }
}
