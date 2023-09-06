<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Bank\Statement\Generate\Request;

use App\Domain\Entity\Order\VO\Number;
use App\Domain\VO\Card\Expiry;

final class Fixture
{
    /** @return array{email:string,startDate:string,endDate:string} */
    public static function data(array $override = []): array
    {
        // @phpstan-ignore-next-line
        return array_merge([
            'email' => 'test@application.local',
            'startDate' => '2023-01-15',
            'endDate' => '2023-06-03',
        ], $override);
    }
}
