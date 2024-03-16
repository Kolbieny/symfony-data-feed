<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Cli;

use Symfony\Component\Console\Command\Command;

abstract class CliCommand extends Command
{
    public function __construct(?string $commandName = null)
    {
        parent::__construct($commandName);
    }
}