<?php

/**
* The LoginAuthenticator is a security component that manages form-based user authentication for the La Boot'ique e-commerce platform. 
* 
* It handles the entire login process, including collecting and validating user credentials, protecting against CSRF attacks, and managing post-authentication redirects. 
* 
* When users log in successfully, the authenticator either redirects them to their originally requested page or to their account dashboard. 
* 
* This class integrates with Symfony's security system to provide a secure authentication mechanism for the application's users.
*/

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    /**
    * Initializes a new instance of the class with a URL generator service that will be used for generating URLs within the application.
    * 
    * @param UrlGeneratorInterface urlGenerator The Symfony URL generator service used to generate URLs for routes within the application
    */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
    * Authenticates a user by creating a Passport object from the submitted credentials. This method extracts the email and password from the request, stores the email in the session, and returns a properly configured Passport object for Symfony's authentication system.
    * 
    * @param Request request The HTTP request containing the user credentials (email, password) and CSRF token
    * 
    * @return Passport object containing the user credentials (UserBadge, PasswordCredentials) and CSRF token validation
    */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    /**
    * Handles the redirect after a successful user authentication. If a target path was previously stored in the session (typically when a user was redirected to login), redirects to that path. Otherwise, redirects to the user's account page.
    * 
    * @param Request $request The HTTP request object containing session data
    * @param TokenInterface $token The authentication token containing the user's security identity
    * @param string $firewallName The name of the firewall that authenticated the user
    * 
    * @return A Response object that redirects either to the previously requested page or to the user's account page, or null if no redirect is needed.
    */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('account'));
    }

    /**
    * Generates the URL for the login page using the application's URL generator.
    * 
    * @param Request request The current HTTP request object
    * 
    * @return A string containing the generated URL for the login page.
    */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
