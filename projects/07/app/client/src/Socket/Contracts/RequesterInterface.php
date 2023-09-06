<?php

declare(strict_types=1);

namespace App\Client\Socket\Contracts;

interface RequesterInterface
{
    public function request(string $value): false | string;
}
