<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\File;

use App\Domain\DirectoryTree\Mime\GioInfoTypeGuesser;
use App\Domain\DirectoryTree\Node\File;
use App\Domain\DirectoryTree\Size\Size;
use Symfony\Component\Mime\MimeTypeGuesserInterface;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Mime\MimeTypesInterface;

final class FileFactory implements Contract\FileFactoryInterface
{
    public function __construct(
        private readonly MimeTypeGuesserInterface $typeGuesser,
        private readonly MimeTypesInterface $extensionGuesser
    ) {
    }

    public function create(string $path, int $depth): Contract\FileInterface
    {
        $name = pathinfo($path, \PATHINFO_BASENAME);
        $type = $this->typeGuesser->guessMimeType($path) ?? 'undefined';
        $extension = $this->extensionGuesser->getExtensions($type)[0] ?? 'undefined';

        return new File($name, $path, new Size((int) filesize($path)), $depth, $type, $extension);
    }

    public static function default(): self
    {
        return new self(GioInfoTypeGuesser::getDefault(), MimeTypes::getDefault());
    }
}
