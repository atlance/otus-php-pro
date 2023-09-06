<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\V1\Bank\Statement\Create;

use App\Infrastructure\Http\Controller\V1\Bank\Statement\Create\Controller;
use App\Tests\Functional\Acceptance\TestCase;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class Code4XXControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{email:string,start_at:string,end_at:string} $content
     */
    public function test(array $content, int $expectCode = Response::HTTP_BAD_REQUEST): void
    {
        $this->requester()->post(Controller::class, content: $content, expectCode: $expectCode);
    }

    public static function dataset(): array
    {
        return [
            // Not valid email -----------------------------------------------------------------------------------------
            'email - required' => [Request\Fixture::data(['email' => null]), Response::HTTP_UNPROCESSABLE_ENTITY],
            // Not valid end_at ---------------------------------------------------------------------------------------
            'end_at - future' => [Request\Fixture::data(['end_at' => self::tomorrow()])],
            'end_at - required' => [Request\Fixture::data(['end_at' => null]), Response::HTTP_UNPROCESSABLE_ENTITY],
            // Not valid start_at -------------------------------------------------------------------------------------
            'start_at - future' => [Request\Fixture::data(['start_at' => self::tomorrow()])],
            'start_at - required' => [Request\Fixture::data(['start_at' => null]), Response::HTTP_UNPROCESSABLE_ENTITY],
            'start_at - greater than end date' => [
                Request\Fixture::data([
                    'start_at' => '2020-06-03',
                    'end_at' => '2020-06-01',
                ])
            ],
        ];
    }

    private static function tomorrow(): string
    {
        return (new \DateTime('+1 day'))->format('Y-m-d');
    }
}
