<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Response;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
final class BadRequest extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: new Model(type: Dto\BadRequest::class))
        );
    }
}
