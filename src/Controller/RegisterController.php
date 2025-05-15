<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\LoginAuthenticator;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegisterController extends AbstractController
{
    /**
     * Handles user registration by creating and processing a registration form. When submitted successfully, it creates a new user account, sends a welcome email, and automatically authenticates the user.
     *
     * @param Request request The HTTP request object containing form data
     * @param UserPasswordHasherInterface userPasswordHasher Service for hashing user passwords securely
     * @param UserAuthenticatorInterface userAuthenticator Service for authenticating users after registration
     * @param LoginAuthenticator authenticator The specific authenticator implementation to use
     * @param EntityManagerInterface em Doctrine entity manager for persisting the user to the database
     * 
     * @return Response object that either redirects to a page after successful authentication or renders the registration form
     */
    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $em): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasher->hashPassword($user,$form->get('password')->getData()));

            $em->persist($user);
            $em->flush();

            $content = "Bonjour {$user->getFirstname()} nous vous remercions de votre inscription";
            (new Mail)->send($user->getEmail(), $user->getFirstname(), "Bienvenue sur la Boot'ique", $content);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
        ]);
    }
}
