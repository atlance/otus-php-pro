<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Directory;

use App\Domain\DirectoryTree\Node\Directory;
use App\Infrastructure\Cli\DirectoryTree\View\Contract;

/**
 * @implements Contract\PresentationTagInterface<Directory>
 */
final class Presenter implements Contract\PresentationTagInterface
{
    private const PATTERN = '%s<fg=#6b9;options=bold,underscore>%s</> [%s]';

    public function present(mixed $element): string
    {
        $prefix = str_repeat('░░', $element->getDepth() - 1);

        return sprintf(self::PATTERN, $prefix, $element->getName(), (string) $element->getSize());
    }

    public static function tag(): string
    {
        return Directory::class;
    }
}
