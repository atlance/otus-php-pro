<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract;

use App\Domain\DirectoryTree\File\Contract\FileInterface;

interface ContentFetcherInterface
{
    /**
     * @param int<0,max>|null $length
     */
    public function fetch(FileInterface $file, int $length = null): ?string;
}
