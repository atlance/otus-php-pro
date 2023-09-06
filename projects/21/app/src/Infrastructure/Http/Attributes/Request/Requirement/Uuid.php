<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Request\Requirement;

final class Uuid
{
    /**
     * Regular expression pattern for matching a UUID of any variant.
     */
    final public const PATTERN = '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}';
}
