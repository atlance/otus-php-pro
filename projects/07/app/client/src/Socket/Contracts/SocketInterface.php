<?php

declare(strict_types=1);

namespace App\Client\Socket\Contracts;

interface SocketInterface
{
    public function read(): false | string;

    public function write(string $value): void;

    public function close(): void;
}
