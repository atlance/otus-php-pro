<?php

declare(strict_types=1);

namespace App\UseCase\FractionToDecimal;

/** @see https://leetcode.com/problems/fraction-to-recurring-decimal */
class Handler
{
    public static function handle(int $numerator, int $denominator): string
    {
        if (0 === $denominator) {
            return '∞';
        }

        if (0 === $numerator) {
            return '0';
        }

        $sign = $numerator * $denominator >= 0 ? '' : '-';
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integerPart = intdiv($numerator, $denominator);
        if (0 === $numerator %= $denominator) {
            return $sign . $integerPart;
        }
        $decimalPart = '';
        $map = [];

        while (0 !== $numerator) {
            if (\array_key_exists($numerator, $map)) {
                $decimalPart = sprintf(
                    '%s(%s)',
                    mb_substr($decimalPart, 0, $map[$numerator]),
                    mb_substr($decimalPart, $map[$numerator], mb_strlen($decimalPart))
                );
                break;
            }
            $map[$numerator] = mb_strlen($decimalPart);
            $numerator *= 10;
            $decimalPart .= intdiv($numerator, $denominator);
            $numerator %= $denominator;
        }

        return $sign . $integerPart . '.' . $decimalPart;
    }
}
