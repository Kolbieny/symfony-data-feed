<?php

declare(strict_types=1);

namespace App\Item\Application\Command;

use App\Item\Application\Service\ItemFileConverter;
use App\Item\Domain\Repository\ItemRepository;
use App\Shared\Application\Command\CommandHandler;

final class ItemImportCommandHandler implements CommandHandler
{
    public function __construct(
        private ItemFileConverter $converter,
        private ItemRepository $repository
    ) {
    }

    /** @var ItemImportCommand $command */
    public function __invoke(\App\Shared\Application\Command\Command $command): void
    {
        $items = $this->converter->convertFromFileToDomainModels($command->filePath);
        $this->repository->saveMultiple($items);
    }
}