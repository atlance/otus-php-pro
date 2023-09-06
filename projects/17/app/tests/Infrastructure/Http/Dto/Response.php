<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Http\Dto;

use App\Application\DataTransferObject;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Response extends DataTransferObject
{
    public int $code;
    public string $type;
    public array $content = [];
    public ResponseHeaderBag $headers;

    public function setContent(mixed $content): void
    {
        $this->content = \is_array($content) ? $content : [$content];
    }
}
