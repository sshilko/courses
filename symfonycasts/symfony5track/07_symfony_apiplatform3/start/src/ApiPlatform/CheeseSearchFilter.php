<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CheeseSearchFilter extends AbstractFilter
{
    protected $properties;

    public function __construct(
        ManagerRegistry $managerRegistry,
        ?RequestStack $requestStack = null,
        LoggerInterface $logger = null,
        array $properties = null,
        NameConverterInterface $nameConverter = null
    ) {
        parent::__construct($managerRegistry, $requestStack, $logger, $properties, $nameConverter);
    }


    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        if ($property !== 'mycheesesearch') {
            return ;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $paramName = $queryNameGenerator->generateParameterName('uniqsearchparam');
        $queryBuilder->andWhere(
            sprintf('%s.title LIKE :%s or %s.description LIKE :%s', $alias, $paramName, $alias, $paramName)
        )->setParameter($paramName, '%' . $value . '%');
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'mycheesesearch' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Search across multiple fields'
                ]
            ],
        ];
    }
}