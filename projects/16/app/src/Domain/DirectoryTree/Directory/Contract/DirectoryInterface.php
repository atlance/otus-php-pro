<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Directory\Contract;

use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Domain\DirectoryTree\Size\Size;

interface DirectoryInterface
{
    public function getName(): string;

    public function getPath(): string;

    public function getSize(): Size;

    /** @return array<int, DirectoryInterface|FileInterface> */
    public function getChildren(): array;
}
