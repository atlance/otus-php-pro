<?php

declare(strict_types=1);

namespace App\ListNode;

final class ListNode
{
    public function __construct(public $val = 0, public ?self $next = null)
    {
    }
}
