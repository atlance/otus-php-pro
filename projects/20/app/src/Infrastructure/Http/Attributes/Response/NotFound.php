<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Response;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
final class NotFound extends OA\Response
{
    public function __construct()
    {
        parent::__construct(response: Response::HTTP_NOT_FOUND, description: 'Not found');
    }
}
