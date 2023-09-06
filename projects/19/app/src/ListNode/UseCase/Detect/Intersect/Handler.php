<?php

declare(strict_types=1);

namespace App\ListNode\UseCase\Detect\Intersect;

use App\ListNode\ListNode;

/**
 * @see https://leetcode.com/problems/intersection-of-two-linked-lists/
 */
final class Handler
{
    public static function handle(ListNode $x, ListNode $y): ?ListNode
    {
        $headX = clone $x;
        $headY = clone $y;
        $map = [];

        while (null !== $headX) {
            if ($headX === $headY) {
                return $headX;
            }
            $map[spl_object_id($headX)] = $headX;
            $headX = $headX->next;
        }

        while (null !== $headY) {
            $id = spl_object_id($headY);
            if (\array_key_exists($id, $map)) {
                return $map[$id];
            }
            $map[$id] = $headY;
            $headY = $headY->next;
        }

        return null;
    }
}
