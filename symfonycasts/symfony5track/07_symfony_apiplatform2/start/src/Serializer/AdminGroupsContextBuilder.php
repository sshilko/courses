<?php

namespace App\Serializer;


use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

final class AdminGroupsContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * Globally adds admin:read and admin:write to all (de)normalization serializations
     */
    private const SERIALIZATION_CONTEXT_GROUP_ADMIN_READ  = 'admin:read';
    private const SERIALIZATION_CONTEXT_GROUP_ADMIN_WRITE = 'admin:write';

    private $decorated;
    private $authorizationChecker;
    private Security $security;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker, Security $security)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

//      $resourceClass = $context['resource_class'] ?? null;
//      if ($resourceClass === User::class &&
        if (isset($context['groups']) &&
            //the same -->
            $this->authorizationChecker->isGranted('ROLE_ADMIN') &&
            $this->security->isGranted('ROLE_ADMIN')
            //the same <--
            ) {
            $context['groups'][] = $normalization ? self::SERIALIZATION_CONTEXT_GROUP_ADMIN_READ
                : self::SERIALIZATION_CONTEXT_GROUP_ADMIN_WRITE;
        }

        return $context;
    }
}