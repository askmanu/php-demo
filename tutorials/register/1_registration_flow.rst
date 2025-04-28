Understanding the Registration Flow
===================================

The user registration process in a Symfony application follows a well-structured architecture that combines controllers, forms, and entities to create a secure and efficient user onboarding experience.

Controller-Form-Entity Architecture
-----------------------------------

At the heart of the registration flow are three key components:

1. **Entity (User)**: Represents the user data structure in the database and implements Symfony's security interfaces (``UserInterface`` and ``PasswordAuthenticatedUserInterface``). The User entity contains properties like email, password, first name, and last name, along with validation constraints to ensure data integrity.

2. **Form (RegisterType)**: Defines the structure and validation rules for the registration form. This form type specifies fields for user information (first name, last name, email) and password with confirmation, along with appropriate validation constraints for each field.

3. **Controller (RegisterController)**: Orchestrates the registration process by creating the form, handling form submission, processing user data, and managing authentication.

Component Interaction Flow
--------------------------

When a user registers for an account, these components interact in the following sequence:

1. The user navigates to the registration page (``/inscription`` route).

2. The ``RegisterController`` creates a new ``User`` entity instance and builds a registration form using the ``RegisterType`` form class.

3. When the user submits the form, the controller validates the input data against the constraints defined in both the form and entity classes.

4. If validation passes, the controller:
   
   - Securely hashes the user's password using Symfony's ``UserPasswordHasherInterface``
   - Persists the new user to the database via Doctrine's ``EntityManagerInterface``
   - Sends a welcome email to the user
   - Automatically authenticates the user using Symfony's security system

5. The user is then redirected to the appropriate page as an authenticated user.

This architecture provides a clean separation of concerns where each component has a specific responsibility: the entity defines the data structure, the form handles input validation, and the controller coordinates the process and manages application flow.

