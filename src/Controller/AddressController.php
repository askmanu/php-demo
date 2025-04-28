<?php

/**
* This controller manages user shipping addresses in the La Boot'ique e-commerce platform. 
* 
* It provides functionality for viewing, adding, updating, and deleting addresses associated with a user's account. 
* 
* The controller ensures security by verifying that users can only access and modify their own addresses. It integrates with the ordering process, allowing seamless address creation during checkout. 
* The implementation follows Symfony's controller patterns, using form handling for data validation and Doctrine ORM for database persistence. 
* 
* Address management is a critical component of the e-commerce user experience, enabling customers to maintain multiple shipping destinations for their orders.
*/

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
    * Renders the user's addresses page in the account section.
    * 
    * @return A Response object containing the rendered 'account/address.html.twig' template.
    */
    #[Route('compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
        ]);
    }

    /**
    * Handles the creation of a new address for the authenticated user. Displays an address form and processes the submission. After successful creation, redirects either to the order process (if initiated from there) or to the address listing page.
    * 
    * @param Request request The HTTP request object containing form data
    * @param EntityManagerInterface em Doctrine entity manager for database operations
    * @param SessionInterface session The session service to check if the address creation was initiated from the order process
    * 
    * @return Response object containing either a redirect to the address listing or order page, or the rendered address form
    */
    #[Route('compte/adresses/ajouter', name: 'account_address_new')]
    public function add(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $em->persist($address);
            $em->flush();
            if ($session->get('order') === 1) {
                $session->set('order', 0);
                return $this->redirectToRoute('order');
            }
            return $this->redirectToRoute('account_address');
        }

        return $this->renderForm('account/address_form.html.twig', [
            'form' => $form
        ]);
    }

    /**
    * Updates a user's address. Validates that the address belongs to the current user, processes the submitted form data, and persists changes to the database. If the form is not submitted or contains invalid data, renders the address update form.
    * 
    * @param Request request The HTTP request object containing form data
    * @param EntityManagerInterface em Doctrine entity manager for database operations
    * @param Address|null address The address entity to be updated, can be null
    * 
    * @return Response object containing either a redirect to the address listing page (on successful update or invalid address) or the rendered address form template
    */
    #[Route('compte/adresses/modifier/{id}', name: 'account_address_update')]
    public function update(Request $request, EntityManagerInterface $em, Address $address = null): Response
    {
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $em->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->renderForm('account/address_form.html.twig', [
            'form' => $form
        ]);
    }

    /**
    * Deletes a user's address if it exists and belongs to the currently authenticated user, then redirects to the address management page.
    * 
    * @param EntityManagerInterface em Symfony's entity manager for database operations
    * @param Address|null address The address entity to be deleted, can be null
    * 
    * @return Response object that redirects to the account address management page
    */
    #[Route('compte/adresses/supprimer/{id}', name: 'account_address_delete')]
    public function delete(EntityManagerInterface $em, Address $address = null): Response
    {
        if ($address && $address->getUser() == $this->getUser()) {
            $em->remove($address);
            $em->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
