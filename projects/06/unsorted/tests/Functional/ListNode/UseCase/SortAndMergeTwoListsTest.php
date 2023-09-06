<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode\UseCase;

use App\ListNode\ListNode;
use App\ListNode\UseCase\SortAndMergeTwoLists;
use PHPUnit\Framework\TestCase;

class SortAndMergeTwoListsTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(ListNode $listNode1, ListNode $listNode2, ListNode $expected): void
    {
        self::assertEquals($expected, SortAndMergeTwoLists::merge($listNode1, $listNode2));
    }

    public static function datasets(): array
    {
        return [
            [
                new ListNode(2, new ListNode(4)),
                new ListNode(1, new ListNode(3, new ListNode(5))),
                new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5))))),
            ],
        ];
    }
}
