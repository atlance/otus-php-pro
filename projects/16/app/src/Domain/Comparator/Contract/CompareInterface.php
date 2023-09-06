<?php

declare(strict_types=1);

namespace App\Domain\Comparator\Contract;

/** @template T */
interface CompareInterface
{
    /** @param T $element */
    public function compare(mixed $element): bool;

    public function isSupported(mixed $element): bool;
}
