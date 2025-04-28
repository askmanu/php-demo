Building the Registration Form
==============================

The registration form is a critical component of the user registration process, serving as the interface through which new users provide their information to create an account. Let's examine how this form is constructed in our Symfony application.

Form Structure and Definition
-----------------------------

The registration form is defined in a dedicated form class called ``RegisterType`` which extends Symfony's ``AbstractType``. This class is responsible for defining the structure, fields, and validation rules for the registration form.

.. code-block:: php

    class RegisterType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            // Form field definitions
        }
        
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => User::class,
            ]);
        }
    }

The form is configured to work with the ``User`` entity, which means that the form fields will be mapped directly to properties of the User object.

Form Fields and Validation
--------------------------

The registration form includes several fields, each with specific validation constraints:

1. **First Name** - A text field with a minimum length requirement of 3 characters
2. **Last Name** - A text field with similar validation
3. **Email** - An email field with email format validation
4. **Password** - A special repeated password field for secure password entry

Each field is configured with appropriate labels, placeholders, and validation constraints:

.. code-block:: php

    $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'constraints' => new Length(['min' => 3]),
            'attr' => [
                'placeholder' => 'Jean'
            ]
        ])
        // Other fields...

Password Field Implementation
-----------------------------

The password field deserves special attention as it uses Symfony's ``RepeatedType`` to ensure that users correctly confirm their password:

.. code-block:: php

    ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'invalid_message' => 'Les mots de passe doivent être identiques',
        'first_options'  => [
            'label' => 'Mot de passe',
            'attr' => ['placeholder' => 'Saisir mot de passe ']
        ],
        'second_options' => [
            'label' => 'Répétez mot de passe',
            'attr' => ['placeholder' => 'Confirmer mot de passe ']
        ],
        // Additional options and constraints
    ])

This implementation creates two password fields that must match, with an error message displayed if they don't. The password is also subject to length constraints, requiring a minimum of 4 characters for security.

Form Styling and User Experience
--------------------------------

The form includes several user experience enhancements:

1. **Placeholders** in each field to guide users on expected input
2. **Clear labels** in French to identify each field
3. **Bootstrap styling** through CSS classes
4. **Validation messages** that provide helpful feedback when input doesn't meet requirements
5. **Submit button** styled as a Bootstrap success button

The form is designed to be user-friendly while ensuring that the data collected meets the application's requirements for creating a valid user account.

Form Processing
---------------

When the form is submitted, the ``RegisterController`` processes it, creating a new user with the provided information:

.. code-block:: php

    $form = $this->createForm(RegisterType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Process form data and create user
    }

This controller validates the form submission, hashes the password securely, persists the new user to the database, and handles post-registration actions like sending a welcome email and authenticating the user.

By carefully designing the registration form with appropriate validation constraints and user-friendly features, the application ensures a secure and smooth registration experience for new users.
