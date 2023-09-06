<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View;

use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\DirectoryTreeInterface;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\PresentationInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DirectoryTree implements DirectoryTreeInterface
{
    public function __construct(private readonly PresentationInterface $presenter)
    {
    }

    /** {@inheritdoc} */
    public function output(\RecursiveIterator $iterator, OutputInterface $output): void
    {
        /** @var iterable<DirectoryInterface|FileInterface> $nodes */
        $nodes = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($nodes as $node) {
            $output->writeln($this->presenter->present($node));
        }
    }
}
