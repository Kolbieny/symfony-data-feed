<?php

declare(strict_types=1);

namespace App\Item\Infrastructure\Dto;

use JMS\Serializer\Annotation\SerializedName;

final readonly class ItemXml
{
    public function __construct(
        #[SerializedName('entity_id')]
        public int $id,
        #[SerializedName('CategoryName')]
        public string $categoryName,
        public string $sku,
        public string $name,
        public ?string $description,
        #[SerializedName('shortdesc')]
        public string $shortDesc,
        public float $price,
        public string $link,
        public string $image,
        #[SerializedName('Brand')]
        public string $brand,
        #[SerializedName('Rating')]
        public ?int $rating,
        #[SerializedName('CaffeineType')]
        public ?string $caffeineType,
        #[SerializedName('Count')]
        public ?int $count,
        #[SerializedName('Flavored')]
        public ?string $flavored,
        #[SerializedName('Seasonal')]
        public ?string $seasonal,
        #[SerializedName('Instock')]
        public string $inStock,
        #[SerializedName('Facebook')]
        public bool $facebook,
        #[SerializedName('IsKCup')]
        public bool $isKCup
    ) {
    }
}