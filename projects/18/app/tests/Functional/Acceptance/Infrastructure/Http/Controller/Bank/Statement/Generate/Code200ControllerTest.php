<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Bank\Statement\Generate;

use App\Tests\Functional\Acceptance\TestCase;
use App\Infrastructure\Http\Controller\Bank\Statement\Generate\Controller;

/** @see Controller */
class Code200ControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{email:string,startDate:string,endDate:string} $content
     */
    public function test(array $content): void
    {
        $response = $this->requester()->post(Controller::class, content: $content);

        self::assertArrayHasKey('status', $response->content);
        self::assertIsString($response->content['status']);
        self::assertEquals('ok', $response->content['status']);
    }

    public static function dataset(): array
    {
        return [
            'full dataset' => [Request\Fixture::data()],
        ];
    }
}
