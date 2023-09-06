<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Bank\Statement\Generate;

use App\Infrastructure\Http\Controller\Bank\Statement\Generate\Controller;
use App\Tests\Functional\Acceptance\TestCase;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class Code400ControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{email:string,startDate:string,endDate:string} $content
     */
    public function test(array $content): void
    {
        $this->requester()->post(Controller::class, content: $content, expectCode: Response::HTTP_BAD_REQUEST);
    }

    public static function dataset(): array
    {
        return [
            // Not valid email -----------------------------------------------------------------------------------------
            'email - required' => [Request\Fixture::data(['email' => null])],
            // Not valid endDate ---------------------------------------------------------------------------------------
            'endDate - future' => [Request\Fixture::data(['endDate' => self::tomorrow()])],
            'endDate - required' => [Request\Fixture::data(['endDate' => null])],
            // Not valid startDate -------------------------------------------------------------------------------------
            'startDate - future' => [Request\Fixture::data(['startDate' => self::tomorrow()])],
            'startDate - required' => [Request\Fixture::data(['startDate' => null])],
            'startDate - greater than end date' => [
                Request\Fixture::data([
                    'startDate' => '2020-06-03',
                    'endDate' => '2020-06-01',
                ])
            ],
        ];
    }

    private static function tomorrow(): string
    {
        return (new \DateTime('+1 day'))->format('Y-m-d');
    }
}
