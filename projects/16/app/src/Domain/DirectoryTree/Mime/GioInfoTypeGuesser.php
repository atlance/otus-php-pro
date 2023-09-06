<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Mime;

use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException;
use Symfony\Component\Mime\MimeTypeGuesserInterface;

/**
 * GIO(Gnome Input/Output) - commandline tool.
 *
 * @see https://manpages.ubuntu.com/manpages/kinetic/man1/gio.1.html
 */
final class GioInfoTypeGuesser implements MimeTypeGuesserInterface
{
    private static ?bool $supported = null;

    public function __construct(
        private readonly string $cmd = "gio info %s 2> /dev/null | grep standard::content-type | cut -d' ' -f4"
    ) {
    }

    /** {@inheritdoc} */
    public function isGuesserSupported(): bool
    {
        if (null !== self::$supported) {
            return self::$supported;
        }

        if (
            '\\' === \DIRECTORY_SEPARATOR
            || !\function_exists('passthru')
            || !\function_exists('escapeshellarg')
        ) {
            return self::$supported = false;
        }

        ob_start();
        passthru('command -v gio', $exitStatus);
        $binPath = trim((string) ob_get_clean());

        return self::$supported = 0 === $exitStatus && '' !== $binPath;
    }

    /** {@inheritdoc} */
    public function guessMimeType(string $path): ?string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf('The "%s" file does not exist or is not readable.', $path));
        }

        if (!$this->isGuesserSupported()) {
            throw new LogicException(sprintf('The "%s" guesser is not supported.', self::class));
        }

        ob_start();

        passthru(sprintf($this->cmd, escapeshellarg((str_starts_with($path, '-') ? './' : '') . $path)), $exitCode);
        if ($exitCode > 0) {
            ob_end_clean();

            return null;
        }

        $type = trim((string) ob_get_clean());

        $result = preg_match('#^([a-z0-9\-]+/[a-z0-9\-\+\.]+)#i', $type, $match);

        if (false === $result || 0 === $result) {
            return null;
        }

        return $match[1];
    }

    public static function getDefault(): self
    {
        return new self();
    }
}
