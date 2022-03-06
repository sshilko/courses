<?php

namespace App\Serializer\Normalizer;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED_FLAG='jshadfasghfkljdfkjhagsdjfgasdf';

    private const GROUP_OWNER_READ = 'owner:read';
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    /**
     * @param User $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        if ($this->userIsOwner($object)) {
            $context['groups'][] = self::GROUP_OWNER_READ;
        }

        $context[self::ALREADY_CALLED_FLAG] = true;
        $data = $this->normalizer->normalize($object, $format, $context);

        // Here: add, edit, or delete some data

        return $data;
    }

    private function userIsOwner(User $user): bool
    {
        /** @var User|null $authenticatedUser */
        $authenticatedUser = $this->security->getUser();

        if ($authenticatedUser && $authenticatedUser->getId() === $user->getId()) {
            return true;
        }

        return false;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        /**
         * cant have true, so sacrifice performance
         * false == prevents recursion
         * because we rely on context, cant have caching
         */
        return false;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED_FLAG])) {
            return false;
        }
        return $data instanceof \App\Entity\User;
    }
}
