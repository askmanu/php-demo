<?php

/**
* A Symfony form type class that creates a password change form for users in the La Boot'ique e-commerce platform. 
* 
* The form displays the user's email, first name, and last name as read-only fields, while requiring the current password and a new password with confirmation. 
* 
* The new password must meet specific validation requirements, including minimum length. 
* 
* The form includes French-language labels and placeholders, and features Bootstrap-styled elements including a submission button. 
* 
* This component enables users to securely update their account passwords while viewing their personal information.
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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    /**
    * Builds a user password change form with read-only personal information fields and validated password input fields. The form includes the user's email, first name, and last name as disabled fields, inputs for the current password and new password (with confirmation), and a submit button.
    * 
    * @param FormBuilderInterface builder The form builder instance used to create the form structure
    * @param array options An array of options that configure the form
    * 
    * @return void
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Adresse email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Nom de famille'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => ['placeholder' => 'Saisir mot de passe souhaité']
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
                'label' => 'Enregistrer modifications',
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }

    /**
    * Configures the options for this form type by setting the data_class default to the User entity class.
    * 
    * @param OptionsResolver resolver The resolver object used to define options and their defaults for the form type
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
