<?php

declare(strict_types=1);

namespace App\Application;

abstract class DataTransferObject
{
    /** @param array<string, mixed> $properties */
    public static function fromHashtable(array $properties = []): static
    {
        $object = new static(); /* @phpstan-ignore-line */

        /** @psalm-var mixed $value */
        foreach ($properties as $property => $value) {
            if (\is_string($value) && '' === $value = trim($value)) {
                continue;
            }

            if ([] === $value || null === $value) {
                continue;
            }

            $method = 'set' . ucfirst($property);
            if (\is_callable([$object, $method])) {
                $object->{$method}($value); /* @phpstan-ignore-line */

                continue;
            }

            if (property_exists(static::class, $property)) {
                $object->{$property} = $value; /* @phpstan-ignore-line */
            }
        }

        return $object;
    }
}
