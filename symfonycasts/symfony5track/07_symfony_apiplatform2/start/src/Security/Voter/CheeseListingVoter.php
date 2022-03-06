<?php

namespace App\Security\Voter;

use App\Entity\CheeseListing;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CheeseListingVoter extends Voter
{
    public const ALLOW_CHEESELISTING_EDIT = 'ALLOW_CHEESELISTING_EDIT';
    public const ABRACADABRA = 'ABRACADABRA';

    private $logger;
    private Security $security;

    public function __construct(LoggerInterface $logger, Security $security)
    {
        $this->logger = $logger;
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ALLOW_CHEESELISTING_EDIT, self::ABRACADABRA])
            && $subject instanceof \App\Entity\CheeseListing;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $this->logger->critical('VOTING ON ' . $attribute);

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var CheeseListing $subject */
        if ($attribute === self::ALLOW_CHEESELISTING_EDIT)
        {
            //$this->logger->critical($user->getId() . ' == VOTING BB ' . $subject->getOwner()->getId());

            if ($subject->getOwner() == $user) {
                return true;
            }

            if ($this->security->isGranted('ROLE_ADMIN')) {
                return true;
            }
        }

        return false;
    }
}
