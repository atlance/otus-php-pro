<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\SimpleCache;

final class InvalidArgumentException extends \Exception implements \Psr\SimpleCache\InvalidArgumentException
{
}
