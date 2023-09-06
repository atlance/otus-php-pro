<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Response\Dto;

use App\Domain\DataTransferObject;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class BadRequest extends DataTransferObject
{
    #[OA\Property(default: Response::HTTP_BAD_REQUEST)]
    public int $status;

    #[OA\Property(default: 'Validation Failed')]
    public string $title;

    #[OA\Property(description: 'Детальное описание, все ошибки в одной строке.', type: 'string')]
    public string $detail;

    #[OA\Property(
        description: 'Название свойства и массив допущенных в нем ошибок',
        properties: [
            new OA\Property(
                property: 'property_name',
                type: 'array',
                items: new OA\Items(type: 'string', example: 'not valid string length')
            ),
        ],
        type: 'object',
    )]
    public object $violations;
}
