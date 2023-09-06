<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\Update;

use App\EventStorage\Presentation\Controller\Event\Update\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

/** @see Controller */
class ControllerTest extends TestCase
{
    public function test(): void
    {
        $this->requester()->post(Controller::class, ['id' => $this->getRandomEventId()], self::fixture());
    }

    public function test404(): void
    {
        $this->requester()
            ->post(
                Controller::class,
                ['id' => Uuid::v4()->toRfc4122()],
                self::fixture(),
                expectCode: Response::HTTP_NOT_FOUND
            );
    }

    public static function fixture(): array
    {
        return [
            'priority' => 102030,
            'name' => 'Test',
            'conditions' => ['test' => 1],
        ];
    }
}
