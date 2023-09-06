<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\FindOne\Relevant;

use App\Core\Application\Command\AbstractCommand;
use App\Core\Application\Validation\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class Command extends AbstractCommand
{
    #[Assert\NotBlank]
    #[Assert\Count(min: 1)]
    #[Assert\All(new Assert\Type('scalar'))]
    #[AppAssert\ArrayKeysOfType(type: 'string')]
    public array $conditions;
}
