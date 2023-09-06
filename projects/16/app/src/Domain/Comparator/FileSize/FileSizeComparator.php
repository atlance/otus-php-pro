<?php

declare(strict_types=1);

namespace App\Domain\Comparator\FileSize;

use App\Domain\Comparator\Comparison;
use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Domain\DirectoryTree\Size\Size;

/**
 * @implements CompareInterface<FileInterface>
 */
final class FileSizeComparator implements CompareInterface
{
    public function __construct(private readonly Comparison $comparison, private readonly Size $size)
    {
    }

    public function compare(mixed $element): bool
    {
        return match ($this->comparison) {
            Comparison::EQ => $element->getSize()->byte() === $this->size->byte(),
            Comparison::NEQ => $element->getSize()->byte() !== $this->size->byte(),
            Comparison::GT => $element->getSize()->byte() > $this->size->byte(),
            Comparison::GTE => $element->getSize()->byte() >= $this->size->byte(),
            Comparison::LT => $element->getSize()->byte() < $this->size->byte(),
            Comparison::LTE => $element->getSize()->byte() <= $this->size->byte(),
        };
    }

    public function isSupported(mixed $element): bool
    {
        return $element instanceof FileInterface;
    }
}
