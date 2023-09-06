<?php

declare(strict_types=1);

namespace App\ListNode;

final class ListNode
{
    public function __construct(public int $val, public ?self $next = null)
    {
    }
}
