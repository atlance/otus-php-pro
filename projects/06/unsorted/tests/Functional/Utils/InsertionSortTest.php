<?php

declare(strict_types=1);

namespace App\Tests\Functional\Utils;

use App\Utils\InsertionSort;
use PHPUnit\Framework\TestCase;

class InsertionSortTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(array $expected, array $data): void
    {
        self::assertEquals($expected, InsertionSort::sort($data));
    }

    public static function datasets(): array
    {
        return [
            [[1, 2, 3, 4, 5], [3, 5, 4, 1, 2]],
            [[-1, 0, 1, 2], [1, -1, 0, 2]],
            [[1], [1]],
            [[], []],
        ];
    }
}
