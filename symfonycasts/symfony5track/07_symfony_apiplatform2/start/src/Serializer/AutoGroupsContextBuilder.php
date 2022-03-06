<?php

namespace App\Serializer;


use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

final class AutoGroupsContextBuilder implements SerializerContextBuilderInterface
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

        $context['groups'] = $context['groups'] ?? [];

        //comment out, redundant to AutoGroupsContextBuilder, it already adds default groups -->
        //$context['groups'] = array_merge($context['groups'], $this->addDefaultGroups($context, $normalization));
        //comment out, redundant to AutoGroupsContextBuilder, it already adds default groups <--

//      $resourceClass = $context['resource_class'] ?? null;
//      if ($resourceClass === User::class &&
        if (//the same -->
            $this->authorizationChecker->isGranted('ROLE_ADMIN') &&
            $this->security->isGranted('ROLE_ADMIN')
            //the same <--
            ) {
            $context['groups'][] = $normalization ? self::SERIALIZATION_CONTEXT_GROUP_ADMIN_READ
                : self::SERIALIZATION_CONTEXT_GROUP_ADMIN_WRITE;
        }

        $context['groups'] = array_unique($context['groups']);

        return $context;
    }

    private function addDefaultGroups(array $context, bool $normalization)
    {
        $resourceClass = $context['resource_class'] ?? null;
        if (!$resourceClass) {
            return null;
        }
        $shortName = (new \ReflectionClass($resourceClass))->getShortName();
        $classAlias = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($shortName)));
        $readOrWrite = $normalization ? 'read' : 'write';
        $itemOrCollection = $context['operation_type'];
        $operationName = $itemOrCollection === 'item' ? $context['item_operation_name'] : $context['collection_operation_name'];
        return [
            // {class}:{read/write}
            // e.g. user:read
            sprintf('%s:%s', $classAlias, $readOrWrite),
            // {class}:{item/collection}:{read/write}
            // e.g. user:collection:read
            sprintf('%s:%s:%s', $classAlias, $itemOrCollection, $readOrWrite),
            // {class}:{item/collection}:{operationName}
            // e.g. user:collection:get
            sprintf('%s:%s:%s', $classAlias, $itemOrCollection, $operationName),
        ];
    }

}