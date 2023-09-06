<?php

declare(strict_types=1);

namespace App\Bookstore\Console\Book;

use App\Bookstore\UseCase;
use App\Core\Console\Output\ConstraintViolationTable;
use App\Core\Console\Output\EntitiesTable;
use App\Core\Validator\CommandValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class SearchCommand extends Command
{
    public function __construct(
        private readonly CommandValidator $validator,
        private readonly UseCase\Book\Search\Handler $handler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('bookstore:book:search')
            ->setDescription('Поиск книг.')
            ->setDefinition(
                new InputDefinition([
                    new InputOption(
                        'title',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: 'Example: --title="рыцОри".'
                    ),
                    new InputOption(
                        'category',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: 'Example: --category="Детектив".'
                    ),
                    new InputOption(
                        'skus',
                        mode: InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                        description: 'Example: --skus="501-347" --skus="500-861" --skus="501-598".'
                    ),
                    new InputOption(
                        'price',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: 'Example: --price=437.',
                    ),
                    new InputOption(
                        'rangePrice',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: <<<TXT
                        Example: --rangePrice="gte=100&lt=1000".
                            Equivalent: price >= 100 and price < 1000.
                            Range:
                            - gt - greater than(>).
                            - gte - greater than or equal to(>=).
                            - lt - less than(<).
                            - lte - less than or equal to(<=).
                        TXT,
                    ),
                    new InputOption(
                        'street',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: 'Example: --street="Мира".',
                    ),
                    new InputOption(
                        'stock',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: 'Example: --stock=3.',
                    ),
                    new InputOption(
                        'rangeStock',
                        mode: InputOption::VALUE_OPTIONAL,
                        description: <<<TXT
                        Example: --rangeStock="gte=100&lt=1000".
                            Equivalent: stock >= 100 and stock < 1000.
                            Range:
                            - gt - greater than(>).
                            - gte - greater than or equal to(>=).
                            - lt - less than(<).
                            - lte - less than or equal to(<=).
                        TXT,
                    ),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = (new UseCase\Book\Search\Command($input->getOptions()));

        try {
            $violations = $this->validator->validate($command);
            if (0 !== \count($violations)) {
                ConstraintViolationTable::render($output, $violations);

                return self::INVALID;
            }

            EntitiesTable::render($output, $this->handler->handle($command));
        } catch (\Throwable $e) {
            $output->write($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
