<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Validator\IsValidOwner;

class IsValidOwnerValidator extends ConstraintValidator
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var IsValidOwner $constraint */
        /* @var User $value */

        if (null === $value || '' === $value) {
            /**
             * value is valid, use NotBlank for non-empty constraint
             */
            return;
        }

        if (!$value instanceof User) {
            throw new \InvalidArgumentException(__CLASS__ . ' only applies to User entity');
        }

        $user = $this->security->getUser();
        if (!$user instanceof User)
        {
            /**
             * Not logged in
             */
            $this->context->buildViolation($constraint->anonmessage)
                ->addViolation();
            return;
        }

        if ($this->security->isGranted('ROLE_ADMIN'))
        {
            /**
             * Allow admin
             */
            return;
        }

        if ($value->getId() != $user->getId()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
