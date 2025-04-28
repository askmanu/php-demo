<?php

/**
* This file defines a Symfony form class called ContactType that creates a contact form for the La Boot'ique e-commerce platform. 
* 
* The form collects user information including first name, last name, email address, and a message. It includes a submit button styled with Bootstrap classes. 
* 
* The form fields are labeled in French, consistent with the platform's localization. 
* This component enables the contact system functionality mentioned in the project description, allowing customers to communicate with the store administrators.
*/

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
    * Builds a contact form with fields for first name, last name, email, message content, and a submit button. Each field is configured with appropriate types and French labels.
    * 
    * @param FormBuilderInterface builder The form builder instance used to create the form structure
    * @param array options An array of options that configure the form
    * 
    * @return void
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label'=> 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label'=> 'Email'
            ])
            ->add('content', TextareaType::class, [
                'label'=> 'Message'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }

    /**
    * Configures the default options for this form type. This method is used to set default values for various form options using the OptionsResolver component.
    * 
    * @param OptionsResolver $resolver The resolver for the options
    * 
    * @return void
    */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
