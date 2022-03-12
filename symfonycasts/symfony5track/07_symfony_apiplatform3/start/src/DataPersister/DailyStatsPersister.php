<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\DailyStats;
use Psr\Log\LoggerInterface;

class DailyStatsPersister implements DataPersisterInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function supports($data): bool
    {
        return $data instanceof DailyStats;
    }

    /**
     * @param DailyStats $data
     * @return object|void
     */
    public function persist($data)
    {
        $this->logger->info('Updated the visitors to ' . $data->totalVisitors);

    }

    public function remove($data)
    {
        throw new \Exception('Not supported');
    }
}