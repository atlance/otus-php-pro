<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\File\Content;

use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Infrastructure\Cli\DirectoryTree\View\File\Content\Contract\ContentFetcherInterface;
use Symfony\Contracts\Service\ServiceProviderInterface;

final class Fetcher implements ContentFetcherInterface
{
    /**
     * @param ServiceProviderInterface<ContentFetcherInterface> $handlers
     */
    public function __construct(private readonly ServiceProviderInterface $handlers)
    {
    }

    public function fetch(FileInterface $file, int $length = null): ?string
    {
        if ($this->handlers->has($file->getExtension())) {
            return $this->handlers->get($file->getExtension())->fetch($file, $length);
        }

        return null;
    }
}
