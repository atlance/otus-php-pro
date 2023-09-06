<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract;

interface ContentTagFetcherInterface extends ContentFetcherInterface
{
    public static function tag(): string;
}
