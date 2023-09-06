<?php

declare(strict_types=1);

namespace App\Core\Presentation\Controller\Attributes;

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
