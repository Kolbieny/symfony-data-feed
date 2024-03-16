<?php

declare(strict_types=1);

namespace App\Item\Domain\Model;

use App\Shared\Domain\Model\AggregateRoot;

final class Item implements AggregateRoot
{
    public function __construct(
        public int $id,
        public string $categoryName,
        public string $sku,
        public string $name,
        public ?string $description,
        public string $shortDesc,
        public ?float $price,
        public string $link,
        public string $image,
        public string $brand,
        public ?int $rating,
        public ?string $caffeineType,
        public ?int $count,
        public ?string $flavored,
        public ?string $seasonal,
        public string $inStock,
        public bool $facebook,
        public bool $isKCup
    ) {
    }
}