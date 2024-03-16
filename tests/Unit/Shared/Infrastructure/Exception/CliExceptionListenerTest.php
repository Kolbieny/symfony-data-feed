<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Exception;

use App\Shared\Infrastructure\Exception\CliExceptionListener;
use App\Shared\Presentation\Cli\CliCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CliExceptionListenerTest extends TestCase
{
    private LoggerInterface&MockObject $loggerMock;

    private CliExceptionListener $exceptionListener;

    public function setUp(): void
    {
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->exceptionListener = new CliExceptionListener($this->loggerMock);
    }

    public function testOnConsoleErrorWhenNotInstanceOfCliCommandThenSkips(): void
    {
        $consoleErrorEvent = $this->getConsoleErrorEvent();
        $this->loggerMock->expects($this->never())->method('error');

        $this->exceptionListener->onConsoleError($consoleErrorEvent);
    }

    public function testOnConsoleErrorWhenAnInstanceOfCliCommandThenLog(): void
    {
        $consoleErrorEvent = $this->getConsoleErrorEvent(true);
        $this->loggerMock->expects($this->once())->method('error');

        $this->exceptionListener->onConsoleError($consoleErrorEvent);
    }

    private function getConsoleErrorEvent(bool $withCliCommand = false): ConsoleErrorEvent
    {
        $command = $withCliCommand
            ? $this->createStub(CliCommand::class)
            : $this->createStub(Command::class);

        $exception = new \Exception(previous: new \Exception());

        return new ConsoleErrorEvent(
            $this->createStub(InputInterface::class),
            $this->createStub(OutputInterface::class),
            $exception,
            $command,
        );
    }
}