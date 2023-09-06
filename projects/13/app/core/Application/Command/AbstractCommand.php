<?php

declare(strict_types=1);

namespace App\Core\Application\Command;

abstract class AbstractCommand
{
    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties = [])
    {
        /** @psalm-var mixed $value */
        foreach ($properties as $property => $value) {
            if (\is_string($value) && '' === $value = trim($value)) {
                continue;
            }

            if ([] === $value || null === $value) {
                continue;
            }

            $method = 'set' . ucfirst($property);
            if (\is_callable([$this, $method])) {
                $this->{$method}($value); /* @phpstan-ignore-line */

                continue;
            }

            if (property_exists(static::class, $property)) {
                $this->{$property} = $value; /* @phpstan-ignore-line */
            }
        }
    }
}
