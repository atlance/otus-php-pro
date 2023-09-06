<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Directory;

final class DirectoryFirstSorter
{
    public static function sort(string $a, string $b): int
    {
        if (is_dir($a) && is_file($b)) {
            return -1;
        }
        if (is_file($a) && is_dir($b)) {
            return 1;
        }

        return 0;
    }
}
