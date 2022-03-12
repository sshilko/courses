<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"daily-stats:read"}},
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "controller"=NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *     },
 *     collectionOperations={"get"}
 * )
 */
class DailyStats
{
    /**
     * @Groups({"daily-stats:read"})
     */
    public \DateTimeInterface $date;

    /**
     * @Groups({"daily-stats:read"})
     * @var int
     */
    public int $totalVisitors;

    /**
     * @Groups({"daily-stats:read"})
     * @var CheeseListing[]
     */
    public array $mostPopularListings;

    public function __construct(\DateTimeInterface $date, int $totalVisitors, array $mostPopularListings)
    {
        $this->date = $date;
        $this->totalVisitors = $totalVisitors;
        $this->mostPopularListings = $mostPopularListings;
    }

    /**
     * @ApiProperty(identifier=true)
     * @return string
     */
    public function getDateString(): string
    {
        return $this->date->format('Y-m-d');
    }

}