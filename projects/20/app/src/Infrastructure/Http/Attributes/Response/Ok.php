<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Response;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
final class Ok extends OA\Response
{
    public function __construct(string $class, string $description = 'Ok')
    {
        parent::__construct(
            response: Response::HTTP_OK,
            description: $description,
            content: new OA\JsonContent(ref: new Model(type: $class))
        );
    }
}
