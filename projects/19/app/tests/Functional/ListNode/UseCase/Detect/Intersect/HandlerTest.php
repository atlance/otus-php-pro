<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode\UseCase\Detect\Intersect;

use App\ListNode\ListNode;
use App\ListNode\UseCase\Detect\Intersect\Handler;
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase
{
    /**
     * @dataProvider datasets
     */
    public function test(ListNode $a, ListNode $b, ?ListNode $expected = null): void
    {
        self::assertEquals($expected, Handler::handle($a, $b));
    }

    /**
     * @see https://leetcode.com/problems/intersection-of-two-linked-lists/description/ - Example 1, 2, 3.
     */
    public static function datasets(): array
    {
        return [
            (static function (): array {
                $a1 = new ListNode(4);
                $a2 = new ListNode(1);
                $a3 = new ListNode(8);
                $a4 = new ListNode(4);
                $a5 = new ListNode(5);

                $a1->next = $a2;
                $a2->next = $a3;
                $a3->next = $a4;
                $a4->next = $a5;

                $b1 = new ListNode(5);
                $b2 = new ListNode(6);

                $b1->next = $b2;
                $b2->next = $a2;

                return [$a1, $b1, $a2];
            })(),
            (static function (): array {
                $a1 = new ListNode(1);
                $a2 = new ListNode(9);
                $a3 = new ListNode(1);
                $a4 = new ListNode(2);
                $a5 = new ListNode(4);

                $a1->next = $a2;
                $a2->next = $a3;
                $a3->next = $a4;
                $a4->next = $a5;

                $b1 = new ListNode(3);

                $b1->next = $a4;

                return [$a1, $b1, $a4];
            })(),
            (static function (): array {
                $a1 = new ListNode(2);
                $a2 = new ListNode(6);
                $a3 = new ListNode(4);

                $a1->next = $a2;
                $a2->next = $a3;

                $b1 = new ListNode(1);
                $b2 = new ListNode(6);

                $b1->next = $b2;

                return [$a1, $b1, null];
            })(),
        ];
    }
}
