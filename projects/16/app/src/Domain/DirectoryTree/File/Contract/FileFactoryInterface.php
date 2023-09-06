<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\File\Contract;

interface FileFactoryInterface
{
    public function create(string $path, int $depth): FileInterface;
}
