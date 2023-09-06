<?php

declare(strict_types=1);

namespace App\ListNode\UseCase\Merge;

use App\ListNode\ListNode;

final class Handler
{
    public static function handle(?ListNode $list1, ?ListNode $list2): ListNode
    {
        if (null === $list1 && null === $list2) {
            throw new \InvalidArgumentException('unexpected lists');
        }

        if (null === $list1) {
            return $list2;
        }

        if (null === $list2) {
            return $list1;
        }

        if ($list1->val > $list2->val) {
            [$list1, $list2] = [$list2, $list1];
        }

        $list1->next = self::handle($list1->next, $list2);

        return $list1;
    }
}
