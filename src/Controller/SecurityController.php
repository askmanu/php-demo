<?php

/**
* This SecurityController manages user authentication in the La Boot'ique e-commerce platform. 
* It provides two key functions: a login method that renders the authentication form and handles login attempts, and a logout method that works with Symfony's security firewall. 
* The login function checks if a user is already authenticated (redirecting them to their account if so), retrieves any authentication errors, and passes the necessary data to the login template. 
* 
* The controller integrates with Symfony's security components to provide a streamlined authentication experience for customers accessing the e-commerce platform.
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /**
    * Handles the login page rendering and authentication process. If a user is already authenticated, redirects to the account page. Otherwise, renders the login form with any previous authentication errors.
    * 
    * @param AuthenticationUtils authenticationUtils Symfony utility service that provides authentication-related helper methods
    * 
    * @return Response object containing either a redirect to the account page (for authenticated users) or the rendered login form
    */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
    * Placeholder method for logout functionality. This method is not meant to be called directly as the logout process is handled by Symfony's security firewall configuration.
    * 
    * @return void - This method doesn't return anything as it always throws an exception.
    * 
    * @throws \LogicException - Always thrown to indicate that this method should not be called directly as the logout process is handled by Symfony's security firewall configuration.
    */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
