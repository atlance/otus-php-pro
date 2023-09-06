<?php

declare(strict_types=1);

namespace App\Application\UseCase\Validation;

use App\Core\Application\Command\AbstractCommand;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends AbstractCommand
{
    #[Assert\NotBlank]
    #[Assert\Regex('#^([^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++)$|^[^\(\)]*$#')]
    public string $string;
}
