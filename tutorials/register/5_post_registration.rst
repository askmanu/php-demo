Post-Registration Actions: Email Confirmation and Auto-Authentication
=====================================================================

After a user successfully completes the registration process, the application performs two important actions to enhance the user experience: sending a welcome email and automatically authenticating the user.

Welcome Email Confirmation
--------------------------

Once the user data is persisted to the database, the application sends a welcome email to confirm the registration:

.. code-block:: php

    // From RegisterController.php
    $content = "Bonjour {$user->getFirstname()} nous vous remercions de votre inscription";
    (new Mail)->send($user->getEmail(), $user->getFirstname(), "Bienvenue sur la Boot'ique", $content);

This email serves multiple purposes:

- It confirms to users that their registration was successful
- It provides a welcoming experience to new users
- It creates a record of the registration that users can reference

The email is sent using a custom Mail service that handles the email delivery process, making it easy to maintain and modify the email content and formatting as needed.

Automatic Authentication
------------------------

Immediately after registration, users are automatically logged in without having to enter their credentials again:

.. code-block:: php

    // From RegisterController.php
    return $userAuthenticator->authenticateUser(
        $user,
        $authenticator,
        $request
    );

This auto-authentication process leverages Symfony's security system through:

- ``UserAuthenticatorInterface`` - The service that handles the authentication process
- ``LoginAuthenticator`` - A custom authenticator that defines how users are authenticated

The benefits of automatic authentication include:

- Seamless user experience with no interruption after registration
- Reduced friction in the onboarding process
- Immediate access to authenticated user features

This approach creates a smooth transition from registration to using the application, eliminating the need for users to manually log in after creating their account.