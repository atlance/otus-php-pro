<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Contract;

use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;

/**
 * @template T of DirectoryInterface|FileInterface
 * @extends PresentationInterface<T>
 */
interface PresentationTagInterface extends PresentationInterface
{
    public static function tag(): string;
}
