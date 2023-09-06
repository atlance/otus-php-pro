<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Contract;

use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface DirectoryTreeInterface
{
    /**
     * @param \RecursiveIterator<int,DirectoryInterface|FileInterface> $iterator
     */
    public function output(\RecursiveIterator $iterator, OutputInterface $output): void;
}
