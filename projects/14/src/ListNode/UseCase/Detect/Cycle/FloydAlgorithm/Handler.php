<?php

declare(strict_types=1);

namespace App\ListNode\UseCase\Detect\Cycle\FloydAlgorithm;

use App\ListNode\ListNode;

final class Handler
{
    public static function handle(ListNode $head): bool
    {
        $walker = $head;
        $runner = $head;

        while ($runner && $runner->next) {
            $walker = $walker->next;
            $runner = $runner->next->next;

            if ($walker === $runner) {
                return true;
            }
        }

        return false;
    }
}
