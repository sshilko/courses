<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\Metadata\Resource\ResourceMetadata;

/**
 * Because we implemented App/Serializer/AdminGroupsContextBuilder
 * we need this to keep API-Platform docs in-sync with our dynamic groups
 */

class AutoGroupResourceMetadataFactory implements ResourceMetadataFactoryInterface
{
    private ResourceMetadataFactoryInterface $decorated;

    public function __construct(ResourceMetadataFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function create(string $resourceClass): ResourceMetadata
    {
        $metadata = $this->decorated->create($resourceClass);

        return $metadata;
    }
}