<?php

namespace App\Doctrine;

use App\Entity\CheeseListing;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

/**
 * EntityListener only called for specific entity events,
 * explicitly specified in services/annotations
 */

class CheeseListingSetOwnerListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(CheeseListing $cheeseListing)
    {
        if ($cheeseListing->getOwner()) {
            return;
        }

        /** @var User $user */
        if ($user = $this->security->getUser()) {
            $cheeseListing->setOwner($user);
        }
    }
}