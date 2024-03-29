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
        $resourceMetadata = $this->decorated->create($resourceClass);

        /**
         * Add automatic groups
         */
        //CUSTOM LOGIC -->
        $itemOperations = $resourceMetadata->getItemOperations();
        $resourceMetadata = $resourceMetadata->withItemOperations(
            $this->updateContextOnOperations($itemOperations, $resourceMetadata->getShortName(), true)
        );
        $collectionOperations = $resourceMetadata->getCollectionOperations();
        $resourceMetadata = $resourceMetadata->withCollectionOperations(
            $this->updateContextOnOperations($collectionOperations, $resourceMetadata->getShortName(), false)
        );
        //CUSTOM LOGIC <--

        return $resourceMetadata;
    }

    private function updateContextOnOperations(array $operations, string $shortName, bool $isItem)
    {
        /**
         * $operationName = [get, put, delete, post]
         */
        foreach ($operations as $operationName => $operationOptions) {
            $operationOptions['normalization_context'] = $operationOptions['normalization_context'] ?? [];
            $operationOptions['normalization_context']['groups'] = $operationOptions['normalization_context']['groups'] ?? [];
            $operationOptions['normalization_context']['groups'] = array_unique(array_merge(
                                                                                    $operationOptions['normalization_context']['groups'],
                                                                                    $this->getDefaultGroups($shortName, true, $isItem, $operationName)
                                                                                ));
            $operationOptions['denormalization_context'] = $operationOptions['denormalization_context'] ?? [];
            $operationOptions['denormalization_context']['groups'] = $operationOptions['denormalization_context']['groups'] ?? [];
            $operationOptions['denormalization_context']['groups'] = array_unique(array_merge(
                                                                                      $operationOptions['denormalization_context']['groups'],
                                                                                      $this->getDefaultGroups($shortName, false, $isItem, $operationName)
                                                                                  ));
            $operations[$operationName] = $operationOptions;
        }
        return $operations;
    }
    private function getDefaultGroups(string $shortName, bool $normalization, bool $isItem, string $operationName)
    {
        $shortName = strtolower($shortName);
        $readOrWrite = $normalization ? 'read' : 'write';
        $itemOrCollection = $isItem ? 'item' : 'collection';
        return [
            // {shortName}:{read/write}
            // e.g. user:read
            //      user:write
            sprintf('%s:%s', $shortName, $readOrWrite),
            // {shortName}:{item/collection}:{read/write}
            // e.g. user:collection:read user:collection:write
            //      user:item:read       user:item:write
            sprintf('%s:%s:%s', $shortName, $itemOrCollection, $readOrWrite),
            // {shortName}:{item/collection}:{operationName}
            // user:collection:get user:collection:post user:collection:put user:collection:delete
            // user:item:get       user:item:post       user:item:put       user:item:delete
            sprintf('%s:%s:%s', $shortName, $itemOrCollection, $operationName),
        ];
    }
}