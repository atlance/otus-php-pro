<?php

declare(strict_types=1);

namespace App\Application\Validation\Dto;

use App\Application\DataTransferObject;
use Symfony\Component\HttpFoundation\Response;

final class BadRequestMessage extends DataTransferObject
{
    public int $status = Response::HTTP_BAD_REQUEST;
    public string $title;
    public string $detail;
    public array $violations = [];
}
