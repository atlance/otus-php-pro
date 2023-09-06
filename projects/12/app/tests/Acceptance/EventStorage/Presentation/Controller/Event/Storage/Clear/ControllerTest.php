<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\Storage\Clear;

use App\EventStorage\Presentation\Controller\Event\Storage\Clear\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;

/** @see Controller */
class ControllerTest extends TestCase
{
    public function test(): void
    {
        $this->requester()->delete(routeClass: Controller::class);
    }
}
