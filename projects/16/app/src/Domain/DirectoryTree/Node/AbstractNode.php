<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Node;

use App\Domain\DirectoryTree\Size\Size;

abstract class AbstractNode
{
    public function __construct(
        private readonly string $name,
        private readonly string $path,
        private readonly Size $size,
        private readonly int $depth,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): Size
    {
        return $this->size;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }
}
