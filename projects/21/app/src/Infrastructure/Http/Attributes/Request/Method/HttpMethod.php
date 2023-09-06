<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Request\Method;

enum HttpMethod
{
    case GET;
    case POST;
    case HEAD;
    case OPTIONS;
    case PATCH;
    case PUT;
    case DELETE;
}
