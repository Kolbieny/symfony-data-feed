<?php

declare(strict_types=1);

namespace App\Item\Application\Service;

use App\Item\Domain\Model\Item;
use App\Shared\Application\Exception\FileNotFoundException;

interface ItemFileConverter
{
    /**
     * @return Item[]
     * @throws FileNotFoundException
     */
    public function convertFromFileToDomainModels(string $filePath): array;
}