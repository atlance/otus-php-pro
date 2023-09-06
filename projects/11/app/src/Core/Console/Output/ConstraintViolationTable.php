<?php

declare(strict_types=1);

namespace App\Core\Console\Output;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ConstraintViolationTable
{
    public static function render(OutputInterface $output, ConstraintViolationListInterface $violationList): void
    {
        (new Table($output))
            ->setHeaderTitle('Неверные параметры')
            ->setHeaders(['Параметр', 'Сообщение'])
            ->setRows(self::rows($violationList))
            ->render()
        ;
    }

    private static function rows(ConstraintViolationListInterface $violationList): array
    {
        $violations = [];
        $rows = [];

        foreach ($violationList as $violation) {
            $violations[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        foreach ($violations as $key => $violation) {
            $rows[] = [$key, implode(', ', $violation)];
        }

        return $rows;
    }
}
