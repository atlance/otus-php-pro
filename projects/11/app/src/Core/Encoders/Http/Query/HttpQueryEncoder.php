<?php

declare(strict_types=1);

namespace App\Core\Encoders\Http\Query;

final class HttpQueryEncoder
{
    public static function encode(object | array $data): string
    {
        return http_build_query($data);
    }

    public static function decode(string $data): array
    {
        mb_parse_str($data, $result);

        return $result;
    }
}
