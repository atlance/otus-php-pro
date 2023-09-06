<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree;

use App\Domain\Comparator;
use App\Domain\DirectoryTree\Filter\SizeFilter;
use App\Domain\DirectoryTree\Node\Directory;
use App\Exceptions\Assert\Assert;

final class DirectoryTreeBuilder implements Contract\BuilderInterface
{
    private ?string $path = null;

    /** @var array<int,Comparator\Contract\CompareInterface> */
    private array $sizes;

    public function in(string $path): self
    {
        Assert::dir($path);

        $builder = clone $this;
        $builder->path = $path;

        return $builder;
    }

    public function withDirSize(Comparator\Comparison $comparison, Size\Size $size): self
    {
        $builder = clone $this;
        $builder->sizes[] = new Comparator\FileSize\DirectorySizeComparator($comparison, $size);

        return $builder;
    }

    public function withFileSize(Comparator\Comparison $comparison, Size\Size $size): self
    {
        $builder = clone $this;
        $builder->sizes[] = new Comparator\FileSize\FileSizeComparator($comparison, $size);

        return $builder;
    }

    /** {@inheritdoc} */
    public function build(): \RecursiveIterator
    {
        if (null === $this->path) {
            throw new \LogicException('You must call in() method before build');
        }

        $iterator = new DirectoryTreeIterator(new Directory($this->path));
        if ([] !== $this->sizes) {
            $iterator = new SizeFilter($iterator, ...$this->sizes);
        }

        return $iterator;
    }
}
