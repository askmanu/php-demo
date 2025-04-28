<?php

/**
* A Symfony controller responsible for email functionality. 
* 
* This controller provides a route for sending emails through the application's Mail service. When accessed, it sends a test email with predefined parameters and redirects the user to the home page. 
* 
* This component serves as an interface between the application's routing system and the email service implementation.
*/

namespace App\Controller;

use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
    * A controller endpoint that demonstrates the email sending functionality by sending a test email and redirecting to the home page.
    * 
    * @return A Symfony Response object that redirects the user to the home page.
    */
    #[Route('/mailer', name: 'mailer')]
    public function index(): Response
    {
        $mail = new Mail();
        $mail->send('bonnal.tristan91@gmail.com', 'Tristan', 'test', 'contenu');
        return $this->redirectToRoute('home');
    }
}
