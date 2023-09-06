<?php

declare(strict_types=1);

namespace App\Server;

final class App
{
    /** @var resource */
    private $stream;

    public function __construct()
    {
        if (($filepath = get_cfg_var('app_socket_filepath')) && !\is_string($filepath)) {
            throw new \DomainException('app_socket_filepath not defined');
        }

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $stream = stream_socket_server("unix://{$filepath}", $errCode, $errMsg);

        if (!\is_resource($stream)) {
            throw new \DomainException("{$errMsg} ({$errCode})");
        }

        $this->stream = $stream;
    }

    public function run(): void
    {
        $connects = [];

        while (true) {
            $read = $connects;
            $read[] = $this->stream;
            $write = $except = null;

            if (!stream_select($read, $write, $except, null)) {
                break;
            }

            if (\in_array($this->stream, $read)) {
                $connection = stream_socket_accept($this->stream);
                $connects[] = $connection;
                unset($read[array_search($this->stream, $read)]);
            }

            foreach ($read as $connection) {
                $buffer = '';
                while (!str_contains($buffer, \PHP_EOL)) {
                    $buffer .= fread($connection, 2046);
                }
                fwrite(\STDOUT, $buffer);
                fwrite($connection, 'Received ' . mb_strlen($buffer) - 1 . ' bytes.' . \PHP_EOL);

                unset($connects[array_search($connection, $connects)]);
            }
        }
    }
}
