<?php

declare(strict_types=1);

namespace App\Item\Application\Command;

use App\Shared\Application\Command\Command;

final readonly class ItemImportCommand implements Command
{
    public function __construct(
        public string $filePath
    ) {
    }
}