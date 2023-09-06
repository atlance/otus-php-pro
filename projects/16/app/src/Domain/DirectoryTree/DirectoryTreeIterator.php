<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree;

use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Domain\DirectoryTree\Node\Directory;
use App\Exceptions\UnexpectedValueException;

/**
 * @implements \RecursiveIterator<int,FileInterface|DirectoryInterface>
 */
final class DirectoryTreeIterator implements \RecursiveIterator
{
    private int $position;

    /** @var array<int, FileInterface|DirectoryInterface> */
    private readonly array $nodes;

    public function __construct(DirectoryInterface $node)
    {
        $this->nodes = $node->getChildren();
    }

    /** {@inheritdoc} */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /** {@inheritdoc} */
    public function valid(): bool
    {
        return $this->position < \count($this->nodes);
    }

    /** {@inheritdoc} */
    public function key(): int
    {
        return $this->position;
    }

    /** {@inheritdoc} */
    public function current(): mixed
    {
        return $this->nodes[$this->position];
    }

    /** {@inheritdoc} */
    public function next(): void
    {
        ++$this->position;
    }

    /** {@inheritdoc} */
    public function getChildren(): self
    {
        if ($this->valid() && $this->nodes[$this->position] instanceof DirectoryInterface) {
            return new self($this->nodes[$this->position]);
        }

        throw new UnexpectedValueException(sprintf('expected %s class', DirectoryInterface::class));
    }

    /** {@inheritdoc} */
    public function hasChildren(): bool
    {
        return $this->nodes[$this->position] instanceof Directory;
    }
}
