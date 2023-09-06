<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Hydrator\Factory;

use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use App\Core\Infrastructure\Cache\Hydrator\ObjectHydrator;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ObjectHydratorFactory
{
    public static function create(): ObjectHydratorInterface
    {
        return new ObjectHydrator(
            new Serializer([
                new UidNormalizer(),
                new ObjectNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    propertyTypeExtractor: new PhpDocExtractor()
                ),
                new ArrayDenormalizer(),
                new DateTimeNormalizer(),
            ])
        );
    }
}
