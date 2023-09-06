<?php

declare(strict_types=1);

namespace App\Utils;

final class InsertionSort
{
    public static function sort(array $values): array
    {
        $size = \count($values);

        if (0 === $size || 1 === $size) {
            return $values;
        }

        for ($i = 1; $i < $size; ++$i) {
            $j = $i;
            while (($j > 0) && ($values[$j] < $values[$j - 1])) {
                $tmp = $values[$j - 1];
                $values[$j - 1] = $values[$j];
                $values[$j] = $tmp;
                --$j;
            }
        }

        return $values;
    }
}
