<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @ApiResource(
 *     paginationItemsPerPage=7,
 *     normalizationContext={"groups"={"daily-stats:read"}},
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 */
class DailyStats
{
    /**
     * @Groups({"daily-stats:read"})
     */
    public $date;

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