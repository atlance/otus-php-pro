<?php

declare(strict_types=1);

namespace App\Client\Socket;

use App\Client\Socket\Contracts\SocketInterface;

final class Requester implements Contracts\RequesterInterface
{
    public function __construct(private readonly SocketInterface $socket = new Socket())
    {
    }

    /** {@inheritdoc} */
    public function request(string $value): false | string
    {
        $this->socket->write($value);
        $response = $this->socket->read();
        $this->socket->close();

        return $response;
    }
}
