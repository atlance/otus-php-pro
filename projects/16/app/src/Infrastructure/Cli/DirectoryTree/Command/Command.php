<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\Command;

use App\Domain\Comparator\Comparison;
use App\Domain\DirectoryTree\Contract\BuilderInterface;
use App\Domain\DirectoryTree\Size\Size;
use App\Infrastructure\Cli\DirectoryTree\View\Contract\DirectoryTreeInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class Command extends BaseCommand
{
    public function __construct(
        private readonly BuilderInterface $builder,
        private readonly DirectoryTreeInterface $tree,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('directory:tree')
            ->setDescription(<<<TXT
                Рекурсивно выводит список каталогов и файлов начиная с заданного каталога.
            TXT)
            ->setDefinition(
                new InputDefinition([
                    new InputArgument('dir', mode: InputOption::VALUE_REQUIRED),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->tree->output(
            $this->builder->in((string) $input->getArgument('dir'))
                ->withDirSize(Comparison::LTE, Size::fromString('100 KB'))
                ->withFileSize(Comparison::LTE, Size::fromString('100 KB'))
                ->build(),
            $output
        );

        return self::SUCCESS;
    }
}
