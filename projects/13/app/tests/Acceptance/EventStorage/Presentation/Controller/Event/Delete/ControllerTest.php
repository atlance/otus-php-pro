<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\Delete;

use App\Core\Infrastructure\Database\Pdo\UseCase\Custom\Handler as SQL;
use App\EventStorage\Presentation\Controller\Event\Delete\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

/** @see Controller */
class ControllerTest extends TestCase
{
    public function test(): void
    {
        $id = $this->getRandomEventId();

        $this->requester()->delete(routeClass: Controller::class, routeParams: ['id' => $id]);

        self::assertFalse(
            (new SQL('SELECT EXISTS(SELECT * FROM events WHERE id = :id)'))
                ->handle(\PDO::FETCH_COLUMN, ['id' => $id])
        );
    }

    public function test404(): void
    {
        $this->requester()
            ->delete(Controller::class, ['id' => Uuid::v4()->toRfc4122()], Response::HTTP_NOT_FOUND);
    }
}
