<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @see \App\Controller */
class ControllerTest extends AbstractControllerTest
{
    public const PATH = '/';

    public function emails(): array
    {
        return [
            ['foo', Response::HTTP_OK],
            ['foo bar baz 1 2 3 ! $ @ #', Response::HTTP_OK],
            [123, Response::HTTP_OK],
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

    /** @dataProvider emails */
    public function testEmails(null|string|int $string, int $expectCode): void
    {
        $response = $this->client->request(Request::METHOD_POST, self::PATH, ['body' => ['string' => $string]]);

        $this->assertEquals($expectCode, $response->getStatusCode());
    }

    public function notAllowedMethods(): array
    {
        return [
            [Request::METHOD_CONNECT],
            [Request::METHOD_DELETE],
            [Request::METHOD_GET],
            [Request::METHOD_HEAD],
            [Request::METHOD_OPTIONS],
            [Request::METHOD_PATCH],
            [Request::METHOD_PUT],
            [Request::METHOD_TRACE],
        ];
    }

    /** @dataProvider notAllowedMethods */
    public function testMethodNotAllowed(string $method): void
    {
        $response = $this->client->request($method, self::PATH);

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }
}
