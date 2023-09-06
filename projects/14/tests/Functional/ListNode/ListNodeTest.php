<?php

declare(strict_types=1);

namespace App\Tests\Functional\ListNode;

use App\ListNode\ListNode;
use PHPUnit\Framework\TestCase;

final class ListNodeTest extends TestCase
{
    public function test(): void
    {
        $listNode = new ListNode(1);

        self::assertEquals(1, $listNode->val);
        self::assertNull($listNode->next);
    }
}
