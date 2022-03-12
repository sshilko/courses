<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class UserDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface, DenormalizedIdentifiersAwareItemDataProviderInterface
{
    private CollectionDataProviderInterface $collectionData;
    private Security $security;
    private ItemDataProviderInterface $itemDataProvider;

    public function __construct(CollectionDataProviderInterface $collectionData, Security $security, ItemDataProviderInterface $itemDataProvider)
    {
        $this->collectionData = $collectionData;
        $this->security = $security;
        $this->itemDataProvider = $itemDataProvider;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $users = $this->collectionData->getCollection($resourceClass, $operationName, $context);

        $currentUser = $this->security->getUser();

        /** @var User $user */
        foreach ($users as $user) {
            /**
             * Add custom isMe field, returned on collection call
             */
            $user->setIsMe($currentUser === $user);
        }

        return $users;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === User::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        /** @var User|null $item */
        $item = $this->itemDataProvider->getItem($resourceClass, $id, $operationName, $context);

        if (!$item) {
            return null;
        }

        /**
         * Add custom isMe field, returned on item
         */
        $item->setIsMe($this->security->getUser() === $item);

        return $item;
    }
}