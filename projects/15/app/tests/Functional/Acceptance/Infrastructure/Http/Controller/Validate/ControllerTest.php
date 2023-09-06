<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Validate;

use App\Infrastructure\Http\Controller\Validate\Controller;
use App\Tests\Functional\Acceptance\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class ControllerTest extends ControllerTestCase
{
    /** @dataProvider dataset */
    public function test(null | string | int $string, int $code): void
    {
        $this->requester()->post(Controller::class, content: ['string' => $string], expectCode: $code);
    }

    public static function dataset(): array
    {
        return [
            ['foo', Response::HTTP_OK],
            ['foo(', Response::HTTP_BAD_REQUEST],
            ['foo()', Response::HTTP_OK],
            ['foo)', Response::HTTP_BAD_REQUEST],
            ['foo())', Response::HTTP_BAD_REQUEST],
            ['(()()()()))((((()()()))(()()()(((()))))))', Response::HTTP_BAD_REQUEST],
            ['((()()()()))(()()()())()', Response::HTTP_OK],
            ['(()()()())', Response::HTTP_OK],
            ['', Response::HTTP_BAD_REQUEST],
            [null, Response::HTTP_BAD_REQUEST],
        ];
    }
}
