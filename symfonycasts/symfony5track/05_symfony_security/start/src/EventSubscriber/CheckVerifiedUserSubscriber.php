<?php

namespace App\EventSubscriber;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    private const PRIORITY = -10;

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
            throw new CustomUserMessageAuthenticationException('Cant login w/o verifying email');
        }
    }


    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', self::PRIORITY]
        ];

    }
}