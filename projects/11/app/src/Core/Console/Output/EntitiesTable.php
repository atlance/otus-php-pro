<?php

declare(strict_types=1);

namespace App\Core\Console\Output;

use App\Core\Contracts\ArrayableInterface;
use App\Core\Domain\Contracts\ColumnNamesInterface;
use App\Core\Domain\Contracts\EntityInterface;
use App\Core\Exceptions\UnexpectedClassException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

final class EntitiesTable
{
    private const NEED_INTERFACES = [ColumnNamesInterface::class, ArrayableInterface::class];

    /**
     * @param array<int, EntityInterface | object> $objects
     */
    public static function render(OutputInterface $output, array $objects): void
    {
        if ([] == $objects) {
            return;
        }

        /** @var array<int, ArrayableInterface & ColumnNamesInterface> $objects */
        $table = (new Table($output))
                ->setHeaders($objects[0]->getColumnNames())
                ->setHeaderTitle('Результаты поиска')
            ;

        foreach ($objects as $object) {
            if (!$object instanceof EntityInterface) {
                throw new UnexpectedClassException(implode(', ', self::NEED_INTERFACES));
            }

            $table->addRow($object->toArray());
        }

        $table->render();
    }
}
