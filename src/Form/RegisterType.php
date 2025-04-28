<?php

/**
* This file defines a Symfony form type class called RegisterType that creates and configures the user registration form for the La Boot'ique e-commerce platform. 
* 
* The form includes fields for first name, last name, email, and password (with confirmation), each with appropriate validation constraints and French-language labels. 
* The password field implements Symfony's RepeatedType to ensure password confirmation matches the original entry. 
* 
* The form is bound to the User entity and includes styling compatible with Bootstrap through CSS classes. 
* 
* All form fields feature placeholder text and appropriate validation messages to guide users through the registration process.
*/

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    /**
    * Builds a user registration form with fields for personal information and credentials. The form includes validation constraints for each field and appropriate styling attributes.
    * 
    * @param FormBuilderInterface builder The form builder instance used to construct the form
    * @param array options An array of options for configuring the form
    * 
    * @return void
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => new Length(['min' => 3]),
                'attr' => [
                    'placeholder' => 'Jean'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => new Length(['min' => 3]),
                'attr' => [
                    'placeholder' => 'Passe'
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => new Email(),
                'attr' => [
                    'placeholder' => 'jean.passe@hotgmail.com'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Saisir mot de passe ']
                ],
                'second_options' => [
                    'label' => 'Répétez mot de passe',
                    'attr' => ['placeholder' => 'Confirmer mot de passe ']
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Votre mot de passe doit contenir minimum 8 charactères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }

    /**
    * Configures the options for this form type. Sets the default data class to User, indicating that this form is designed to work with User entities.
    * 
    * @param OptionsResolver resolver The resolver for the form options that allows defining which options are available and their default values
    * 
    * @return void
    */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
