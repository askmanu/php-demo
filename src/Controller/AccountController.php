<?php

/**
* The AccountController manages user account functionality in the La Boot'ique e-commerce platform. 
* 
* It provides four main features: a general account dashboard, password management, order history viewing, and detailed order information. 
* The password change feature includes validation of the current password before allowing updates, with appropriate user feedback through flash messages. 
* The order management functions ensure users can only access their own order history and details, implementing proper security controls. 
* 
* This controller serves as the central hub for authenticated users to manage their personal information and track their purchase history within the application.
*/

namespace App\Controller;

use App\Entity\Order;
use App\Form\ChangePasswordType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AccountController extends AbstractController
{   
    /**
    * Renders the user account page at the '/compte' URL path.
    * 
    * @return A Response object containing the rendered 'account/index.html.twig' template.
    */
    #[Route('/compte', name: 'account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
        ]);
    }

    /**
    * Handles password change functionality for authenticated users. Creates and processes a password change form, validates the current password, and updates to the new password if validation succeeds.
    * 
    * @param Request request The HTTP request object containing form data
    * @param UserPasswordHasherInterface passwordHasher Service for hashing passwords and validating password entries
    * @param EntityManagerInterface em Doctrine entity manager for persisting changes to the database
    * 
    * @return Response object containing either a redirect to the account page (on successful password change) or the rendered password change form
    */
    #[Route('/compte/mot-de-passe', name: 'account_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            $new_password = $form->get('new_password')->getData();
            $isOldPasswordValid = $passwordHasher->isPasswordValid($user, $old_password);
            if ($isOldPasswordValid) {
                $password = $passwordHasher->hashPassword($user,$new_password);
                $user->setPassword($password);
                $em->flush();
                $this->addFlash(
                    'notice', 
                    'Mot de passe modifié :)'
                );
                return $this->redirectToRoute('account');
            } else {
                $this->addFlash(
                    'notice', 
                    'Mot de passe actuel erroné :('
                );
            }
        }

        return $this->renderForm('account/password.html.twig', [
            'form' => $form
        ]);
    }

    /**
    * Displays the list of paid orders for the currently authenticated user in their account section.
    * 
    * @param OrderRepository repository Repository used to fetch the user's paid orders from the database
    * 
    * @return Response object containing the rendered account/orders.html.twig template with the user's paid orders
    */
    #[Route('/compte/commandes', name: 'account_orders')]
    public function showOrders(OrderRepository $repository): Response
    {
        $orders = $repository->findPaidOrdersByUser($this->getUser());
        return $this->render('account/orders.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
    * Displays a specific order details page for the authenticated user. Verifies that the requested order belongs to the current user before rendering the order details template.
    * 
    * @param Order order The order entity to display, automatically resolved from the reference parameter in the URL
    * 
    * @return A Response object containing the rendered order details template with the order information
    * 
    * @throws NotFoundException when the order doesn't exist or doesn't belong to the currently authenticated user
    */
    #[Route('/compte/commandes/{reference}', name: 'account_order')]
    public function showOrder(Order $order): Response
    {
        if (!$order || $order->getUser() != $this->getUser()) {
            throw $this->createNotFoundException('Commande innaccessible');
        }
        return $this->render('account/order.html.twig', [
            'order' => $order
        ]);
    }
}
