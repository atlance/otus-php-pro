<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File\Content\Type;

use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract\ContentTagFetcherInterface;

final class Html implements ContentTagFetcherInterface
{
    public const EXT = 'html';

    public function fetch(FileInterface $file, int $length = null): ?string
    {
        if (false === $content = file_get_contents($file->getPath())) {
            return null;
        }

        return mb_substr(trim(strip_tags($content), " \t\n\r\0\x0B\xC2\xA0"), 0, $length);
    }

    public static function tag(): string
    {
        return self::EXT;
    }
}
