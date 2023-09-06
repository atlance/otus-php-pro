<?php

declare(strict_types=1);

namespace App\Domain\Comparator\Contract;

/** @template T */
interface TransformerInterface
{
    /**
     * @return T
     */
    public function transform(mixed $value): mixed;

    public function reverseTransform(mixed $value): string;
}
