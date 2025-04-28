<?php

/**
* This controller manages the contact form functionality for the La Boot'ique e-commerce platform. 
* It handles the rendering, submission, and processing of the contact form. 
* 
* When users submit the form, the controller validates the input, displays a confirmation message to the user, and sends an email notification to the site administrator containing the visitor's contact information and message. 
* 
* The controller integrates with a custom Mail service to handle email delivery and uses Symfony's form handling capabilities to process user input securely.
*/

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
    * Handles the contact form submission process. Creates and processes a contact form, sends an email notification when a valid form is submitted, and renders the contact page template.
    * 
    * @param Request request The HTTP request object containing form submission data
    * 
    * @return Response object containing the rendered contact form page
    */
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Message envoyé, nous vous répondrons dans les plus brefs délais');
            $datas = $form->getData();
            $content = "De la part de : {$datas['firstname']} {$datas['lastname']} <br> Message : {$datas['content']} <br> Email: {$datas['email']}";
            $mail = new Mail();
            $mail->send('bonnal.tristan91@gmail.com', 'Tristan', 'Contact visiteur La Boot\'ique', $content);
        }

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
