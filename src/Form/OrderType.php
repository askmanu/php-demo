<?php

/**
* This file defines the OrderType form class used in the checkout process of the La Boot'ique e-commerce platform. 
* 
* It creates a form that allows customers to select a delivery address from their saved addresses and choose a shipping carrier before proceeding to payment. 
* 
* The form dynamically loads the user's addresses and displays them as radio button options. 
* 
* It also presents available shipping carriers as radio buttons and includes a styled submit button that directs users to the payment step. 
* 
* The form is built using Symfony's form system and integrates with the platform's Address and Carrier entities.
*/

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    /**
    * Builds a form for the checkout process that allows users to select a shipping address and carrier before proceeding to payment. The form includes the user's saved addresses, available shipping carriers, and a submit button.
    * 
    * @param FormBuilderInterface builder The form builder interface used to construct the form
    * @param array options Configuration options for the form, including the 'user' object whose addresses will be displayed
    * 
    * @return void
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('addresses', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => Address::class,
                'choice_label' => 'addressLabel', //callback récupérant une chaine concaténée
                'choices' => $user->getAddresses(),
                'expanded' => true
            ])
            ->add('carriers', EntityType::class, [
                'label' => 'Choisissez votre transporteur',
                'required' => true,
                'class' => Carrier::class,
                'choice_label' => 'carrierLabel',
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Passer au paiment', 
                'attr' => [
                    'class' => "btn btn-outline-success btn-block"
                ]
            ])
        ;
    }

    /**
    * Configures the options for this form type. Sets a default empty array for the 'user' option, which allows user data to be passed from the controller to the form builder.
    * 
    * @param OptionsResolver resolver The resolver for the form type options
    * 
    * @return void
    */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => []        // Récupère la variable user passée dans le contoller pour la transmettre aux options du buildForm
        ]);
    }
}
