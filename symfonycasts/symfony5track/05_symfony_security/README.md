## You've got the Code for Symfony 5 Security: Authenticators. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!

```
composer require security

symfony console make:user

symfony console make:auth

#Using a Custom Query to Load the User
https://symfony.com/doc/current/security/user_providers.html#using-a-custom-query-to-load-the-user

#https://symfonycasts.com/screencast/symfony-security/user-query-credentials#play


#https://symfony.com/doc/current/security.html#comparing-users-manually-with-equatableinterface


#symfony console debug:router --show-controllers

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
            custom_authenticator: App\Security\LoginFormAuthenticator


security:
    hide_user_not_found: false            

$request->getSession()->set();

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }


error.messageKey is safe for output to user    
"Message key to be used by the translation component."


<input type="hidden" name="_csrf_token" value="{{ csrf_token('authenticate') }}">

name can be anything, but _csrf_token is standard name

'authenticate' argument is also just unique identifier, can be any unique string


symfony console debug:config security

<input type="checkbox" name="_remember_me" class="form-check-input"> Remember me

new RememberMeBadge()

#always enable, ignore whatever checkbox value was
(new RememberMeBadge())->enable()

#get access to anonymous last url when login
    use TargetPathTrait;

$request->getSession()

```