<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage;

use App\Core\Infrastructure\Database\Pdo\UseCase\Custom\Handler as SQL;

class TestCase extends \App\Tests\Acceptance\TestCase
{
    public function getRandomEventId(): string
    {
        return (new SQL('SELECT id FROM events LIMIT 1'))->handle(\PDO::FETCH_COLUMN);
    }
}
