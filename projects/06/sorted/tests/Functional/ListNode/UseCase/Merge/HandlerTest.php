<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode\UseCase\Merge;

use App\ListNode\ListNode;
use App\ListNode\UseCase\Merge\Handler;
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(?ListNode $listNode1, ?ListNode $listNode2, ?ListNode $expected): void
    {
        if (null === $expected) {
            self::expectException(\InvalidArgumentException::class);
        }

        self::assertEquals($expected, Handler::handle($listNode1, $listNode2));
    }

    // Сортированные списки.
    public static function datasets(): array
    {
        return [
            // Четное количество значений.
            [
                new ListNode(2, new ListNode(4)),
                new ListNode(1, new ListNode(3)),
                new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4)))),
            ],
            // Нечетное количество значений.
            [
                new ListNode(2, new ListNode(4)),
                new ListNode(1, new ListNode(3, new ListNode(5))),
                new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5))))),
            ],
            // Наличие отрицательных значений.
            [
                new ListNode(-1, new ListNode(10)),
                new ListNode(-3, new ListNode(0, new ListNode(1))),
                new ListNode(-3, new ListNode(-1, new ListNode(0, new ListNode(1, new ListNode(10))))),
            ],
            // Наличие одинаковых значений.
            [
                new ListNode(1, new ListNode(10)),
                new ListNode(2, new ListNode(10, new ListNode(20))),
                new ListNode(1, new ListNode(2, new ListNode(10, new ListNode(10, new ListNode(20))))),
            ],
            // null значение первого списка.
            [
                null,
                new ListNode(1),
                new ListNode(1),
            ],
            // null значение второго списка.
            [
                new ListNode(2),
                null,
                new ListNode(2),
            ],
            // null значение первого и второго списка.
            [
                null,
                null,
                null,
            ],
        ];
    }
}
