<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\Create;

use App\EventStorage\Presentation\Controller\Event\Create\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class ControllerTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(array $content, int $expectCode): void
    {
        $this->requester()->post(routeClass: Controller::class, content: $content, expectCode: $expectCode);
    }

    public static function datasets(): array
    {
        return [
            // many conditions - 200.
            [
                [
                    'priority' => 10,
                    'conditions' => [
                        'param_one' => 1,
                        'param_two' => 'two',
                        'param_three' => false,
                        'param_four' => 4.200,
                        'param_five' => date('Y-m-d H:i:s'),
                        'param_six' => '6',
                        'param_seven' => null,
                    ],
                ],
                Response::HTTP_OK,
            ],
            // one condition - 200.
            [
                [
                    'priority' => 10,
                    'conditions' => ['param_one' => 'one'],
                ],
                Response::HTTP_OK,
            ],
            // empty string value parameter condition - 400.
            [
                [
                    'priority' => 10,
                    'conditions' => '',
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // negative priority - 400.
            [
                [
                    'priority' => -10,
                    'conditions' => ['param_one' => 'one', 'param_two' => 2],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // without priority - 400.
            [
                [
                    'conditions' => ['param_one' => 'one', 'param_two' => 2],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // with integer key and value - 400.
            [
                [
                    'priority' => 10,
                    'conditions' => [0 => 1],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // with integer key - 400.
            [
                [
                    'priority' => 10,
                    'conditions' => [12 => 'foo'],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // empty conditions - 400.
            [
                [
                    'priority' => 10,
                    'conditions' => [],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
        ];
    }
}
