<?php

declare(strict_types=1);

namespace App\Tests\Integration\Shared\Steps;

use App\Kernel;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class SharedSteps implements Context
{
    private Application $application;

    private BufferedOutput $output;

    private bool $hasCliCommandFailed = false;

    public function __construct(Kernel $kernel)
    {
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
    }

    /** @When The CLI command :command with argument :argument has been called */
    public function theCliCommandWithArgumentHasBeenCalled(string $command, string $argument): void
    {
        try {
            $input = new ArgvInput(['behat', $command, $argument, '--env=test']);
            $this->application->doRun($input, $this->output);
        } catch (\Exception) {
            $this->hasCliCommandFailed = true;
        }
    }

    /** @Then The CLI command responds with :message */
    public function theCliCommandRespondsWith(string $message): void
    {
        Assert::assertSame($message, preg_replace('/\s+/', ' ', trim($this->output->fetch())));
    }

    /** @Then The CLI command failed */
    public function theCliCommandFailed(): void
    {
        Assert::assertTrue($this->hasCliCommandFailed);
    }

    /** @AfterScenario */
    public function resetCliCommandFailedFlag(): void
    {
        $this->hasCliCommandFailed = false;
    }
}