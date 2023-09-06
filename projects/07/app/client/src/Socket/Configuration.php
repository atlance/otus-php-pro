<?php

declare(strict_types=1);

namespace App\Client\Socket;

class Configuration
{
    public string $filepath;

    public function __construct()
    {
        if (($filepath = get_cfg_var('app_socket_filepath')) && !\is_string($filepath)) {
            throw new \DomainException('app_socket_filepath not defined');
        }

        $this->filepath = $filepath;
    }
}
