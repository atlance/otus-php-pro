<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode\UseCase\Detect\Cycle\FloydAlgorithm;

use App\ListNode\ListNode;
use App\ListNode\UseCase\Detect\Cycle\FloydAlgorithm\Handler;
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(ListNode $head, bool $isCycle): void
    {
        true === $isCycle
            ? self::assertTrue(Handler::handle($head))
            : self::assertFalse(Handler::handle($head))
        ;
    }

    /** @see https://leetcode.com/problems/linked-list-cycle/description/ - Example 1, 2, 3. */
    public static function datasets(): array
    {
        return [
            [
                (static function (): ListNode {
                    $node1 = new ListNode(3);
                    $node2 = new ListNode(2);
                    $node3 = new ListNode(0);
                    $node4 = new ListNode(-4);

                    $node1->next = $node2;
                    $node2->next = $node3;
                    $node3->next = $node4;
                    $node4->next = $node2; //<-loop

                    return $node1;
                })(),
                true,
            ],
            [
                (static function (): ListNode {
                    $node1 = new ListNode(1);
                    $node2 = new ListNode(2);

                    $node1->next = $node2;
                    $node2->next = $node1; //<-loop

                    return $node1;
                })(),
                true,
            ],
            [
                new ListNode(1),
                false,
            ],
            [
                (static function (): ListNode {
                    $node1 = new ListNode(1);
                    $node2 = new ListNode(2);
                    $node3 = new ListNode(3);
                    $node4 = new ListNode(4);
                    $node5 = new ListNode(5);
                    $node6 = new ListNode(6);

                    $node1->next = $node2;
                    $node2->next = $node3;
                    $node3->next = $node4;
                    $node4->next = $node5;
                    $node5->next = $node6;

                    return $node1;
                })(),
                false,
            ],
        ];
    }
}
