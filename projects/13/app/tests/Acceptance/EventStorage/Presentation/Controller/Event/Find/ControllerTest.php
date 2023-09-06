<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\Find;

use App\EventStorage\Presentation\Controller\Event\Find\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;

/** @see Controller */
class ControllerTest extends TestCase
{
    public function test(): void
    {
        $this->requester()->get(routeClass: Controller::class, routeParams: ['id' => $this->getRandomEventId()]);
    }
}
