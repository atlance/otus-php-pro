<?php

declare(strict_types=1);

namespace App\Tests\Functional\Phone\UseCase\InputKeys;

use App\Phone\UseCase\InputKeys\Handler;
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(string $digits, array $expected): void
    {
        self::assertEquals($expected, Handler::handle($digits));
    }

    /** @see https://leetcode.com/problems/letter-combinations-of-a-phone-number/description/ - Example 1, 2, 3. */
    public static function datasets(): array
    {
        return [
            ['23', ['ad', 'ae', 'af', 'bd', 'be', 'bf', 'cd', 'ce', 'cf']],
            ['', []],
            ['2', ['a', 'b', 'c']],
            ['37', ['dp', 'dq', 'dr', 'ds', 'ep', 'eq', 'er', 'es', 'fp', 'fq', 'fr', 'fs']],
        ];
    }
}
