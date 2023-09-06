<?php

declare(strict_types=1);

namespace App\Tests\Functional\UseCase\FractionToDecimal;

use App\UseCase\FractionToDecimal\Handler;
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase
{
    /**
     * @dataProvider datasets
     */
    public function test(int $numerator, int $denominator, string $expected): void
    {
        self::assertEquals($expected, Handler::handle($numerator, $denominator));
    }

    /**
     * @see https://leetcode.com/problems/fraction-to-recurring-decimal/description/ - Example 1, 2, 3 + overhead
     */
    public static function datasets(): array
    {
        return [
            [1, 2, '0.5'],
            [2, 1, '2'],
            [4, 333, '0.(012)'],
            // overhead
            [142, 990, '0.1(43)'],
            [-142, 990, '-0.1(43)'],
            [-142, -990, '0.1(43)'],
            [0, 1, '0'],
            [1, 0, '∞'],
        ];
    }
}
