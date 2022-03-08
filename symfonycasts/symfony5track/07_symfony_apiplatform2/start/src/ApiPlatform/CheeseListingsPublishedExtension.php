<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\CheeseListing;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CheeseListingsPublishedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private LoggerInterface $logger;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(LoggerInterface $logger, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->logger = $logger;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {

        if ($resourceClass != CheeseListing::class) {
            return;
        }

        if ($operationName !== 'get') {
            return;
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        $this->addWhereOnlyPublished($queryBuilder);
    }

    protected function addWhereOnlyPublished($queryBuilder)
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.isPublished = :isPublished', $rootAlias))
            ->setParameter('isPublished', true);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ) {
        if ($resourceClass != CheeseListing::class) {
            return;
        }

        if ($operationName !== 'get') {
            return;
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        $this->addWhereOnlyPublished($queryBuilder);
    }
}