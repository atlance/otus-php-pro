<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Core\Application\Command\AbstractCommand;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DtoResponse extends AbstractCommand
{
    public int $code;
    public string $type;
    public array $content = [];
    public ResponseHeaderBag $headers;

    public function setContent(mixed $content): void
    {
        if (!\is_array($content)) {
            $content = [$content];
        }

        $this->content = $content;
    }
}
