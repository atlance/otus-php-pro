<?php

declare(strict_types=1);

namespace App\Client;

use App\Client\Socket\Contracts\RequesterInterface;
use App\Client\Socket\Requester;

final class App
{
    public function __construct(private readonly RequesterInterface $requester = new Requester())
    {
    }

    public function run(): void
    {
        $buffer = '';

        while (($incoming = fgets(\STDIN)) && false === str_contains($incoming, '\q')) {
            $buffer .= $incoming;

            if (str_contains($buffer, \PHP_EOL)) {
                $response = $this->requester->request($buffer);

                if (false !== $response) {
                    fwrite(\STDOUT, $response);
                }

                $buffer = '';
            }
        }
    }
}
