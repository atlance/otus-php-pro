<?php

declare(strict_types=1);

namespace App\Domain\Entity\Order\VO;

class NumberGenerator
{
    private const PERMITTED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generate(int $min, int $max, string $haystack = self::PERMITTED_CHARS): string
    {
        $length = random_int($min, $max);
        $maxIndex = mb_strlen($haystack) - 1;
        $output = '';

        for ($i = 0; $i < $length; ++$i) {
            $output .= $haystack[mt_rand(0, $maxIndex)];
        }

        return $output;
    }
}
