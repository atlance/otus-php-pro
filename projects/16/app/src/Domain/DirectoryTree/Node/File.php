<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Node;

use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Domain\DirectoryTree\Size\Size;

final class File extends AbstractNode implements FileInterface
{
    private readonly string $type;
    private readonly string $extension;

    public function __construct(
        string $name,
        string $path,
        Size $size,
        int $depth,
        string $type,
        string $extension
    ) {
        parent::__construct($name, $path, $size, $depth);

        $this->type = $type;
        $this->extension = $extension;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }
}
