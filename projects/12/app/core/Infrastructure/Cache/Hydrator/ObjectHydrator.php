<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Hydrator;

use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use App\Core\Infrastructure\Cache\Hydrator\Exceptions\ExtractException;
use App\Core\Infrastructure\Cache\Hydrator\Exceptions\HydrateException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ObjectHydrator implements ObjectHydratorInterface
{
    public function __construct(private readonly Serializer $serializer)
    {
    }

    /** {@inheritdoc} */
    public function hydrate($data, string $className)
    {
        try {
            return $this->serializer->denormalize($data, $className);
        } catch (\Throwable $e) {
            throw new HydrateException($e->getMessage());
        }
    }

    /** {@inheritdoc} */
    public function extract(object | array $object): array
    {
        try {
            return (array) $this->serializer->normalize($object, null, [
                AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            ]);
        } catch (\Throwable $e) {
            throw new ExtractException($e->getMessage());
        }
    }
}
