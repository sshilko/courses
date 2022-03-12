<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\ApiPlatform\DailyStatsDataFilter;
use App\Entity\DailyStats;
use App\Repository\CheeseListingRepository;
use App\Service\StatsHelper;

class DailyStatsProvider implements ContextAwareCollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private CheeseListingRepository $cheeseListingRepository;
    private StatsHelper $statsHelper;
    private Pagination $pagination;

    public function __construct(CheeseListingRepository $cheeseListingRepository, StatsHelper $statsHelper, Pagination $pagination)
    {
        $this->cheeseListingRepository = $cheeseListingRepository;
        $this->statsHelper = $statsHelper;
        $this->pagination = $pagination;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        list($page, , $limit) = $this->pagination->getPagination($resourceClass, $operationName);

        $paginator = new DailyStatsPaginator($this->statsHelper, $page, $limit);
        $fromDate = $context[DailyStatsDataFilter::FROM_FILTER_CONTEXT] ?? null;
        if ($fromDate) {
            $paginator->setFromDate($fromDate);
        }

        return $paginator;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass == DailyStats::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        //dd($context);
        return $this->statsHelper->fetchOne($id);
    }
}