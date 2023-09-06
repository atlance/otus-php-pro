<?php

declare(strict_types=1);

namespace App\Domain\Comparator\Contract;

use App\Domain\Comparator\Comparison;

/**
 * @template T1
 * @template T2
 */
interface CompareInterface
{
    /**
     * @param T1 $a
     * @param T2 $b
     */
    public function compare(mixed $a, mixed $b): bool;

    public function comparison(): Comparison;
}
