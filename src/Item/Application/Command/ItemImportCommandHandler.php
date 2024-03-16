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

    public function __invoke(ItemImportCommand $command): void
    {
        $items = $this->converter->convertFromFileToDomainModels($command->filePath);
        $this->repository->saveMultiple($items);
    }
}