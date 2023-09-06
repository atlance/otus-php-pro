<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File;

use App\Domain\DirectoryTree\Node\File;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\PresentationTagInterface;
use App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract\ContentFetcherInterface;

/**
 * @implements PresentationTagInterface<File>
 */
final class Presenter implements PresentationTagInterface
{
    private const PATTERN = '%s<fg=#6e9>%s</> [%s]';

    public function __construct(
        private readonly ContentFetcherInterface $fetcher,
        /** @var int<0,max> */
        private readonly int $length = 50
    ) {
    }

    public function present(mixed $element): string
    {
        $prefix = str_repeat('░░', $element->getDepth() - 1);
        $presentation = sprintf(self::PATTERN, $prefix, $element->getName(), (string) $element->getSize());

        if (null !== $content = $this->fetcher->fetch($element, $this->length)) {
            $presentation = sprintf('%s < %s', $presentation, $content);
        }

        return $presentation;
    }

    public static function tag(): string
    {
        return File::class;
    }
}
