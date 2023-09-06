<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Size;

use App\Exceptions\UnexpectedValueException;

enum Unit: int
{
    case B = 1;
    case KB = 1024;
    case MB = 1048576;
    case GB = 1073741824;
    case TB = 1099511627776;
    case PB = 1125899906842624;
    case EB = 1152921504606846976;
    public static function fromName(string $name): self
    {
        foreach (self::cases() as $case) {
            if ($name === $case->name) {
                return $case;
            }
        }

        throw new UnexpectedValueException();
    }
}
