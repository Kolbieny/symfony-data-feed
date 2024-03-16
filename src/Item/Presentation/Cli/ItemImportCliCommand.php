<?php

declare(strict_types=1);

namespace App\Item\Presentation\Cli;

use App\Item\Application\Command\ItemImportCommand;
use App\Shared\Presentation\Cli\CliCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class ItemImportCliCommand extends CliCommand
{
    use HandleTrait;

    public function __construct(
        private readonly string $projectDir,
        MessageBusInterface $messageBus
    ) {
        parent::__construct('app:item:import');
        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this->addArgument('file',
            InputArgument::REQUIRED,
            'File location, which should be located in /data directory'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $this->projectDir . '/data/' . $input->getArgument('file');
        $this->handle(new ItemImportCommand($filePath));

        $output->writeln('Items have been imported successfully');
        return Command::SUCCESS;
    }
}