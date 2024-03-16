<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Exception;

use App\Shared\Presentation\Cli\CliCommand;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

final class CliExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        if ($event->getCommand() instanceof CliCommand) {
            $this->logger->error(sprintf(
                "[%s] %s. Stack trace: %s",
                $event->getCommand()->getName(),
                $event->getError()->getPrevious()->getMessage(),
                $event->getError()->getPrevious()->getTraceAsString()
            ));
        }
    }
}
