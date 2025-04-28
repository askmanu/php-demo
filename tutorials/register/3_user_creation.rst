Handling Form Submission and User Creation
=========================================

Once we've built our registration form, we need to handle the form submission process and create new user accounts. Let's explore how Symfony processes form submissions and persists user data to the database.

Form Submission Workflow
-----------------------

The form submission process begins in the ``RegisterController``, which handles the HTTP request containing the form data:

.. code-block:: php

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
                         UserAuthenticatorInterface $userAuthenticator, 
                         LoginAuthenticator $authenticator, 
                         EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        // Form processing logic...
    }

The controller creates a new ``User`` entity and binds it to the registration form. When a user submits the form, the ``handleRequest()`` method processes the submitted data and maps it to the entity.

Validation Process
-----------------

Symfony automatically validates the submitted data against the constraints defined in the form and entity classes. For example, our ``RegisterType`` form includes validation constraints like:

- Email validation using ``Email()`` constraint
- Password validation with ``NotBlank()`` and ``Length()`` constraints
- Name validation with minimum length requirements

The controller only proceeds with user creation when the form passes validation:

.. code-block:: php

    if ($form->isSubmitted() && $form->isValid()) {
        // Process valid form data
    }

Password Hashing
---------------

For security, user passwords must never be stored in plain text. The ``UserPasswordHasherInterface`` service handles secure password hashing:

.. code-block:: php

    $user->setPassword($userPasswordHasher->hashPassword(
        $user,
        $form->get('password')->getData()
    ));

This creates a secure hash of the password that can be safely stored in the database while still allowing for password verification during login.

Entity Persistence
----------------

After preparing the user entity with validated data and a hashed password, we persist it to the database using Doctrine's Entity Manager:

.. code-block:: php

    $em->persist($user);
    $em->flush();

The ``persist()`` method tells Doctrine to manage the entity, and ``flush()`` executes the database operations, creating a new record in the user table.

Post-Registration Actions
-----------------------

After successful registration, our application performs two important actions:

1. **Sending a welcome email** to the new user:

   .. code-block:: php

       $content = "Bonjour {$user->getFirstname()} nous vous remercions de votre inscription";
       (new Mail)->send($user->getEmail(), $user->getFirstname(), 
                        "Bienvenue sur la Boot'ique", $content);

2. **Automatic authentication** of the new user, eliminating the need for them to log in separately:

   .. code-block:: php

       return $userAuthenticator->authenticateUser(
           $user,
           $authenticator,
           $request
       );

This creates a seamless registration experience where users can immediately start using the application after completing the registration form.

By following this structured approach to form submission and user creation, we ensure that new accounts are created securely while providing a smooth user experience.
