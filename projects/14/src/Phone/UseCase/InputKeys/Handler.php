<?php

declare(strict_types=1);

namespace App\Phone\UseCase\InputKeys;

final class Handler
{
    public const LETTERS = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];

    public static function handle(string $digits): array
    {
        if ('' === $digits) {
            return [];
        }

        $combinations = self::LETTERS[$digits[0]];
        $size = mb_strlen($digits);

        for ($i = 1; $i < $size; ++$i) {
            $buffer = [];
            ('7' === $digits[$i] || '9' === $digits[$i])
                ? [$one, $two, $free, $four] = self::LETTERS[$digits[$i]]
                : [$one, $two, $free] = self::LETTERS[$digits[$i]];

            foreach ($combinations as $combination) {
                $buffer[] = $combination . $one;
                $buffer[] = $combination . $two;
                $buffer[] = $combination . $free;

                if (isset($four)) {
                    $buffer[] = $combination . $four;
                }
            }

            $combinations = $buffer;
        }

        return $combinations;
    }
}
