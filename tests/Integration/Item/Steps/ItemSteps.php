<?php

declare(strict_types=1);

namespace App\Tests\Integration\Item\Steps;

use App\Item\Domain\Model\Item;
use App\Item\Domain\Repository\ItemRepository;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\Filesystem\Filesystem;

class ItemSteps implements Context
{
    private string $filePath;

    public function __construct(
        private Filesystem $filesystem,
        private ItemRepository $repository,
        private readonly string $projectDir
    ) {
        $this->filePath = $this->projectDir . '/data/test-behat.xml';
    }


    /** @Given The file with data exists and has a following content: */
    public function theFileWithDataExistsAndHasAFollowingContent(string $fileContent): void
    {
        $this->filesystem->touch($this->filePath);
        $this->filesystem->appendToFile($this->filePath, $fileContent);
    }

    /** @Then Item of id :id is saved in database */
    public function itemOfIdIsSavedInDatabase(int $id): void
    {
        $item = $this->repository->findById($id);
        Assert::assertInstanceOf(Item::class, $item);
    }

    /** @Then Item of id :id is not saved in database */
    public function itemOfIdIsNotSavedInDatabase(int $id): void
    {
        $item = $this->repository->findById($id);
        Assert::assertNull($item);
    }

    /** @AfterScenario */
    public function removeTestFile(): void
    {
        if ($this->filesystem->exists($this->filePath)) {
            $this->filesystem->remove($this->filePath);
        }
    }
}