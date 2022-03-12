<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\DailyStats;
use App\Repository\CheeseListingRepository;

class DailyStatsProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private CheeseListingRepository $cheeseListingRepository;

    public function __construct(CheeseListingRepository $cheeseListingRepository)
    {
        $this->cheeseListingRepository = $cheeseListingRepository;
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $result = [];

        $listings = $this->cheeseListingRepository->findBy([], [], 5);

        $result[] = new DailyStats(new \DateTime(), random_int(10, 100), $listings);
        $result[] = new DailyStats(new \DateTime('-1 day'), random_int(10, 100), $listings);
        $result[] = new DailyStats(new \DateTime('-3 months'), random_int(10, 100), $listings);

        return $result;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass == DailyStats::class;
    }
}