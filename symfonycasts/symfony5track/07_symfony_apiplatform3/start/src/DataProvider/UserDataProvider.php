<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class UserDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private CollectionDataProviderInterface $collectionData;
    private Security $security;

    public function __construct(CollectionDataProviderInterface $collectionData, Security $security)
    {
        $this->collectionData = $collectionData;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $users = $this->collectionData->getCollection($resourceClass, $operationName, $context);

        $currentUser = $this->security->getUser();

        /** @var User $user */
        foreach ($users as $user) {
            $user->setIsMe($currentUser === $user);
        }

        return $users;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === User::class;
    }
}