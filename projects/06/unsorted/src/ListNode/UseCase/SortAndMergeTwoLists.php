<?php

declare(strict_types=1);

namespace App\ListNode\UseCase;

use App\ListNode\ListNode;
use App\ListNode\Transformer\ListNodeToArrayTransformer as T;
use App\Utils\InsertionSort;

class SortAndMergeTwoLists
{
    public static function merge(ListNode $list1 = null, ListNode $list2 = null): ListNode
    {
        return T::reverseTransform(InsertionSort::sort(array_merge(T::transform($list1), T::transform($list2))));
    }
}
