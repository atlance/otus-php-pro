<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Update;

use App\Core\Application\Command\AbstractCommand;
use App\Core\Application\Validation\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class Command extends AbstractCommand
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $id;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero(message: 'Неверное количество {{ value }}.')]
    public int $priority;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255, maxMessage: 'Превышен лимит 255 символов')]
    public string $name;

    /** @var array<string,int> */
    #[Assert\All(new Assert\Type('integer'))]
    #[AppAssert\ArrayKeysOfType(type: 'string')]
    public array $conditions = [];
}
