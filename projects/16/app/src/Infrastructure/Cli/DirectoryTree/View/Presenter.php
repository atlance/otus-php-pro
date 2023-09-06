<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View;

use App\Domain\DirectoryTree\Directory\Contract\DirectoryInterface;
use App\Domain\DirectoryTree\File\Contract\FileInterface;
use App\Exceptions\UnexpectedValueException;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\PresentationInterface;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\PresentationTagInterface;
use Symfony\Contracts\Service\ServiceProviderInterface;

/**
 * @implements PresentationInterface<DirectoryInterface|FileInterface>
 */
final class Presenter implements PresentationInterface
{
    /**
     * @param ServiceProviderInterface<PresentationTagInterface> $presenters
     */
    public function __construct(private readonly ServiceProviderInterface $presenters)
    {
    }

    public function present(mixed $element): string
    {
        if ($this->presenters->has($element::class)) {
            return $this->presenters->get($element::class)->present($element);
        }

        throw new UnexpectedValueException(sprintf('Presenter for class: "%s" - not found.', $element::class));
    }
}
