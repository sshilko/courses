<?php

namespace App\Dto;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\CheeseListing;
use Symfony\Component\Serializer\Annotation\Groups;

class CheeseListingOutput
{

    /**
     * @Groups({"cheese:read"})
     */
    public string $title;

    /**
     * @Groups({"cheese:read"})
     */
    public string $description;

    /**
     * @Groups({"cheese:read"})
     */
    public int $price;

}