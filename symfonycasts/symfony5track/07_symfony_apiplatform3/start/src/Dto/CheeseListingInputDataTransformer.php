<?php

namespace App\Dto;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\CheeseListing;

class CheeseListingInputDataTransformer implements DataTransformerInterface
{

    /**
     * @param CheeseListingInput $input
     * @param string $to
     * @param array $context
     * @return object|void
     */
    public function transform($input, string $to, array $context = [])
    {

        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])) {
            //stuff to update (put)
            //title cannot be updated??
            $cheeseListing = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        } else {
            $cheeseListing = new CheeseListing($input->title);
        }
        $cheeseListing->setDescription($input->description);

        $cheeseListing->setPrice($input->price);
        $cheeseListing->setOwner($input->owner);
        $cheeseListing->setIsPublished($input->isPublished);

        return $cheeseListing;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof CheeseListing) {
            return false;
        }

        //dump($data, $to, $context);
        return $to === CheeseListing::class &&
            //can be different classes on different operations
            ($context['input']['class'] ?? null) === CheeseListingInput::class;
    }
}