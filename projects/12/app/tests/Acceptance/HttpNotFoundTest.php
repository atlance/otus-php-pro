<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use Symfony\Component\HttpFoundation\Response;

class HttpNotFoundTest extends TestCase
{
    public function test()
    {
        $client = $this->requester()->getClient();
        $client->request('GET', '/foo/bar');
        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
