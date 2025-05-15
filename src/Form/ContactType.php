<?php

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
     * Builds a form structure by adding text fields for first name and last name, an email field, a textarea for the message content, and a submit button with custom styling.
     *
     * @param FormBuilderInterface $builder The form builder instance used to create the form
     * @param array $options An array of options for configuring the form
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
     * Configures the options for this form type. This method sets default values for various form options using the OptionsResolver component.
     *
     * @param OptionsResolver resolver The resolver for the options
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
