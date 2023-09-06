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
                    'name' => 'Test',
                    'conditions' => [
                        'param_one' => 1,
                        'param_two' => 2,
                        'param_three' => 3,
                        'param_four' => 5,
                        'param_five' => 7,
                        'param_six' => 15,
                        'param_seven' => 14,
                    ],
                ],
                Response::HTTP_OK,
            ],
            // one condition - 200.
            [
                [
                    'priority' => 10,
                    'name' => 'Test',
                    'conditions' => ['param_one' => 1],
                ],
                Response::HTTP_OK,
            ],
            // skip empty string value parameter conditions, use default [] - 200.
            [
                [
                    'priority' => 10,
                    'name' => 'Test',
                    'conditions' => '',
                ],
                Response::HTTP_OK,
            ],
            // negative priority - 400.
            [
                [
                    'priority' => -10,
                    'name' => 'Test',
                    'conditions' => ['param_one' => 1, 'param_two' => 2],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // without priority - 400.
            [
                [
                    'name' => 'Test',
                    'conditions' => ['param_one' => 1, 'param_two' => 2],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // without name - 400.
            [
                [
                    'priority' => 10,
                    'conditions' => ['param_one' => 1, 'param_two' => 2],
                ],
                Response::HTTP_BAD_REQUEST,
            ],
            // with integer key - 400.
            [
                [
                    'priority' => 10,
                    'name' => 'Test',
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
        ];
    }
}
