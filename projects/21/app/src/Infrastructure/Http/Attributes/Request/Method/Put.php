<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Request\Method;

use Symfony\Component\Routing\Annotation\Route;

#[\Attribute]
final class Put extends Route
{
    public function getMethods(): array
    {
        return [HttpMethod::PUT->name];
    }
}
