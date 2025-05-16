<?php

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
    #[Route('compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
        ]);
    }

    /**
     * Handles the creation of a new address for the authenticated user. Creates and processes an address form, persists the new address to the database, and redirects based on whether the user is in the middle of placing an order.
     *
     * @param Request request The HTTP request object containing form data
     * @param EntityManagerInterface em Doctrine entity manager for database operations
     * @param SessionInterface session The session service to check and update order status
     * 
     * @return Response object containing either a redirect to the account address list/order page or the rendered address form template
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
