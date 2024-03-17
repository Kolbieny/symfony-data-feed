<?php

declare(strict_types=1);

namespace App\Tests\Integration\Shared\Steps;

use App\Kernel;
use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

class SharedSteps implements Context
{
    private Application $application;

    private BufferedOutput $output;

    private bool $hasCliCommandFailed = false;
    private string $logPath;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Filesystem $filesystem,
        Kernel $kernel,
    ) {
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
        $this->logPath = $kernel->getLogDir() . '/error_test.log';;
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

    /** @Then There are entries in error log file */
    public function thereAreEntriesInErrorLogFile(): void
    {
        Assert::assertTrue($this->filesystem->exists($this->logPath));
    }

    /** @AfterScenario */
    public function resetCliCommandFailedFlag(): void
    {
        $this->hasCliCommandFailed = false;
    }

    /** @AfterScenario */
    public function removeErrorsLogFile(): void
    {
        if ($this->filesystem->exists($this->logPath)) {
            $this->filesystem->remove($this->logPath);
        }
    }

    /** @AfterScenario */
    public function clearData(): void
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
}