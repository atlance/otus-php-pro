<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\File\Contract;

use App\Domain\DirectoryTree\Size\Size;

interface FileInterface
{
    public function getName(): string;

    public function getPath(): string;

    public function getSize(): Size;

    public function getType(): string;

    public function getExtension(): string;
}
