<?php

declare(strict_types=1);

namespace App\Item\Domain\Repository;

use App\Item\Domain\Model\Item;

interface ItemRepository
{
    /** @param Item[] $items */
    public function saveMultiple(array $items): void;

    public function findById(int $id): ?Item;
}