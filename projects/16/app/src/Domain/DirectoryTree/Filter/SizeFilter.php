<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Filter;

use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface as D;
use App\Domain\DirectoryTree\File\Contract\FileInterface as F;

/**
 * @extends \RecursiveFilterIterator<int,F|D, \RecursiveIterator<int,F|D>>
 */
final class SizeFilter extends \RecursiveFilterIterator
{
    /** @var CompareInterface[] */
    private array $comparators;

    /**
     * @param \RecursiveIterator<int,F|D> $iterator
     * @param CompareInterface            ...$comparators
     */
    public function __construct(\RecursiveIterator $iterator, CompareInterface ...$comparators)
    {
        $this->comparators = $comparators;

        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        /** @var F|D $node */
        $node = $this->current();

        foreach ($this->comparators as $comparator) {
            if (!$comparator->isSupported($node)) {
                continue;
            }
            if (!$comparator->compare($node)) {
                return false;
            }
        }

        return true;
    }
}
