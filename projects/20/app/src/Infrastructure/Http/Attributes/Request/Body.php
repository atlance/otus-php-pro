<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Attributes\Request;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class Body extends OA\RequestBody
{
    public function __construct(string $class)
    {
        parent::__construct(content: new OA\JsonContent(ref: new Model(type: $class)));
    }
}
