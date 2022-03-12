<?php

namespace App\Doctrine;

use App\Entity\User;

class UserSetIsMvpListener
{
    public function postLoad(User $user) {
        /**
         * Will trigger EVERY TIME entity is loaded
         * @todo check symfony LazyString
         */
        $user->setIsMvp(strpos($user->getUsername(), 'cheese') !== false);
    }

}