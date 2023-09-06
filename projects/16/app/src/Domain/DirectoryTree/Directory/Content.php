<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Directory;

final class Content
{
    /**
     * @return array<int,string>
     */
    public static function list(string $path): array
    {
        $list = glob(str_ends_with($path, \DIRECTORY_SEPARATOR) ? "{$path}*" : "{$path}/*");
        if (!\is_array($list)) {
            return [];
        }

        usort($list, [DirectoryFirstSorter::class, 'sort']);

        return $list;
    }
}
