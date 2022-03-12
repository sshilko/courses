<?php

namespace App\Validator;

use App\Entity\CheeseListing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidIsPublishedValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function validate($value, Constraint $constraint)
    {

        /* @var App\Validator\ValidIsPublished $constraint */
        /** @var CheeseListing $value */

        if (!$value instanceof CheeseListing) {
            throw new \LogicException('Only cheeselisting supported');
        }

        $originalData = $this->entityManager->getUnitOfWork()
            ->getOriginalEntityData($value);

        $previous = $originalData['isPublished'] ?? false;

        if ($previous === $value->getIsPublished()) {
            //nothing changed
            return;
        }

        if ($value->getIsPublished()) {
            if (strlen($value->getDescription()) < 100 && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                // TODO: implement the validation here
                $this->context->buildViolation('Cannot publish, description too short')
                    ->atPath('description')
                    ->addViolation();
            }
            return;
        } else {
            //unpublishing

            if (!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {

                //throw new AccessDeniedException('Throw 403 instead');

                $this->context->buildViolation('Cannot unpublish, only admins')
                    ->addViolation();
            }
        }




    }
}