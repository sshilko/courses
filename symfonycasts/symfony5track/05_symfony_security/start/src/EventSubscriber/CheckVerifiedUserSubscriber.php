<?php

namespace App\EventSubscriber;
use App\Entity\User;
use App\Security\AccountNotVerifiedAuthenticationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    private const PRIORITY = -10;
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Called on ALL/ANY firewalls, if multiple exist/defined in app
     *
     * @param CheckPassportEvent $passportEvent
     * @return void
     */
    public function onCheckPassport(CheckPassportEvent $passportEvent)
    {
        $pass = $passportEvent->getPassport();
        if (!$pass instanceof UserPassportInterface) {
            throw new \Exception('never should happen');
        }

        $user = $pass->getUser();

        if (!$user instanceof User) {
            throw new \Exception('never should happen, not expected');
        }

        if (!$user->getIsVerified()) {
            /**
             * Throw any error extending AuthenticationException
             */
            //throw new AuthenticationException();
            throw new AccountNotVerifiedAuthenticationException('Cant login w/o verifying email');
        }
    }

    public function onLoginFailure(LoginFailureEvent $event) {
        if (!$event->getException() instanceof  AccountNotVerifiedAuthenticationException) {
            return;
        }

        $response = new RedirectResponse($this->router->generate('app_verify_resend_email'));
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', self::PRIORITY],
            LoginFailureEvent::class => 'onLoginFailure'
        ];
    }
}