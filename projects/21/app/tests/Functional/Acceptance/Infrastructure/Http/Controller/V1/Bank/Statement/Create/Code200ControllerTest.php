<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\V1\Bank\Statement\Create;

use App\Infrastructure\Http\Controller\V1\Bank\Statement\Create\Controller;
use App\Tests\Functional\Acceptance\TestCase;

/** @see Controller */
class Code200ControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{email:string,start_at:string,end_at:string} $content
     */
    public function test(array $content): void
    {
        $response = $this->requester()->post(Controller::class, content: $content);

        self::assertArrayHasKey('id', $response->content);
        self::assertIsString($response->content['id']);
    }

    public static function dataset(): array
    {
        return [
            'full dataset' => [Request\Fixture::data()],
        ];
    }
}
