<?php

declare(strict_types=1);

namespace App\ListNode\Transformer;

use App\ListNode\ListNode;

final class ListNodeToArrayTransformer
{
    /**
     * @return int[]
     */
    public static function transform(ListNode $listNode): array
    {
        $values = [];
        $values[] = $listNode->val;

        while ($listNode->next) {
            $values[] = $listNode->next->val;

            $listNode = $listNode->next;
        }

        return $values;
    }

    public static function reverseTransform(array $values): ListNode
    {
        $size = \count($values);
        if (0 === $size) {
            throw new \InvalidArgumentException('expected not empty array');
        }

        $rootNode = $listNode = new ListNode($values[0]);

        for ($i = 1; $i < $size; ++$i) {
            while (null !== $listNode->next) {
                $listNode = $listNode->next;
            }

            $listNode->next = new ListNode($values[$i]);
        }

        return $rootNode;
    }
}
