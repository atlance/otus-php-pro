<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Node;

use App\Domain\DirectoryTree\Directory\Content;
use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Domain\DirectoryTree\File\FileFactory;
use App\Domain\DirectoryTree\Size\Size;

final class Directory extends AbstractNode implements DirectoryInterface
{
    /** @var array<int, DirectoryInterface|FileInterface> */
    private array $children = [];

    public function __construct(string $path, int $depth = 0)
    {
        parent::__construct(pathinfo($path, \PATHINFO_BASENAME), $path, new Size(), $depth);

        ++$depth;
        foreach (Content::list($this->getPath()) as $child) {
            $child = $this->addChildren($child, $depth);
            $this->getSize()->add($child->getSize());
        }
    }

    public function addChildren(string $path, int $depth): DirectoryInterface | FileInterface
    {
        $child = is_file($path) ? FileFactory::default()->create($path, $depth) : new self($path, $depth);
        $this->children[] = $child;

        return $child;
    }

    /** {@inheritdoc} */
    public function getChildren(): array
    {
        return $this->children;
    }
}
