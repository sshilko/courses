<?php

namespace App\Dto;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\CheeseListing;

class CheeseListingOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param CheeseListing $cheeseListing
     * @param string $to
     * @param array $context
     * @return self
     */
    public function transform($cheeseListing, string $to, array $context = []): CheeseListingOutput
    {
        $output = new CheeseListingOutput();
        $output->title = $cheeseListing->getTitle();
        $output->price = $cheeseListing->getPrice();
        $output->description = $cheeseListing->getDescription();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof CheeseListing && $to === CheeseListingOutput::class;
    }
}