<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File\Content\Type;

use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract\ContentTagFetcherInterface;

final class Txt implements ContentTagFetcherInterface
{
    public const EXT = 'txt';

    public function fetch(FileInterface $file, int $length = null): ?string
    {
        return (false !== $content = file_get_contents($file->getPath(), length: $length)) ? $content : null;
    }

    public static function tag(): string
    {
        return self::EXT;
    }
}
