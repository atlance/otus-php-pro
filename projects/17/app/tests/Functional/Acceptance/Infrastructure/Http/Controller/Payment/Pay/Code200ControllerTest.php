<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Payment\Pay;

use App\Domain\Entity\Order\VO\Number;
use App\Domain\VO\Card\Expiry;
use App\Infrastructure\Http\Controller\Payment\Pay\Controller;
use App\Tests\Functional\Acceptance\TestCase;

/** @see Controller */
class Code200ControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{number:string,cvv:string,expiry:string,order_number:string,amount:string} $content
     */
    public function test(array $content): void
    {
        $response = $this->requester()->post(Controller::class, content: $content);

        self::assertArrayHasKey('id', $response->content);
        self::assertIsString($response->content['id']);
        self::assertArrayHasKey('payment_id', $response->content);
        self::assertIsString($response->content['payment_id']);
        self::assertArrayHasKey('number', $response->content);
        self::assertArrayHasKey('value', $response->content['number']);
        self::assertEquals($content['order_number'], $response->content['number']['value']);
    }

    public static function dataset(): array
    {
        return [
            'full dataset' => [Request\Fixture::data()],
            'without holder name' => [Request\Fixture::data(['holder' => null])],
        ];
    }
}
