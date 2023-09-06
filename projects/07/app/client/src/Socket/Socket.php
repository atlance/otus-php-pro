<?php

declare(strict_types=1);

namespace App\Client\Socket;

class Socket implements Contracts\SocketInterface
{
    private mixed $stream = null;

    public function __construct(private readonly Configuration $config = new Configuration())
    {
    }

    /** {@inheritdoc} */
    public function read(): false | string
    {
        return fgets($this->stream());
    }

    /** {@inheritdoc} */
    public function write(string $value): void
    {
        fwrite($this->stream(), $value);
    }

    /** {@inheritdoc} */
    public function close(): void
    {
        if (\is_resource($this->stream)) {
            fclose($this->stream);
        }
    }

    private function stream()
    {
        if (!\is_resource($this->stream)) {
            $stream = stream_socket_client("unix://{$this->config->filepath}");

            if (false === \is_resource($stream)) {
                throw new \InvalidArgumentException(sprintf('Argument must be a valid resource type. %s given.', \gettype($stream)));
            }

            $this->stream = $stream;
        }

        return $this->stream;
    }
}
