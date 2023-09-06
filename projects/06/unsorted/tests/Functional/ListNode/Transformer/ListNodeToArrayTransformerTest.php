<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode\Transformer;

use App\ListNode\ListNode;
use App\ListNode\Transformer\ListNodeToArrayTransformer;
use PHPUnit\Framework\TestCase;

class ListNodeToArrayTransformerTest extends TestCase
{
    /** @dataProvider datasets */
    public function testTransform(array $data, ListNode $listNode): void
    {
        self::assertEquals($data, ListNodeToArrayTransformer::transform($listNode));
    }

    /** @dataProvider datasets */
    public function testReverseTransform(array $data, ListNode $listNode): void
    {
        self::assertEquals($listNode, ListNodeToArrayTransformer::reverseTransform($data));
    }

    public function testEmptyArrayReverseTransform(): void
    {
        self::expectExceptionObject(new \InvalidArgumentException('expected not empty array'));

        ListNodeToArrayTransformer::reverseTransform([]);
    }

    public static function datasets(): array
    {
        return [
            [[1, 2, 5], new ListNode(1, new ListNode(2, new ListNode(5)))],
            [[3, 1, 5], new ListNode(3, new ListNode(1, new ListNode(5)))],
            [[3], new ListNode(3)],
        ];
    }
}
