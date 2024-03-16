<?php

declare(strict_types=1);

namespace App\Item\Infrastructure\Mapper;

use App\Item\Domain\Model\Item;
use App\Item\Infrastructure\Dto\ItemXml;

class ItemXmlMapper
{
    /** @param ItemXml[] $items */
    /** @return Item[] */
    public static function multipleFromDtoToDomain(array $items): array
    {
        $nullIfEmpty = fn($value) => $value === "" ? null : $value;
        $nullIfZero = fn($value) => $value === 0 ? null : $value;

        $domainItems = [];
        foreach ($items as $item) {
            $domainItems[] = new Item(
                $nullIfZero($item->id),
                $item->categoryName,
                $item->sku,
                $item->name,
                $nullIfEmpty($item->description),
                $item->shortDesc,
                $nullIfEmpty($item->price),
                $item->link,
                $item->image,
                $item->brand,
                $nullIfEmpty($item->rating),
                $nullIfEmpty($item->caffeineType),
                $nullIfEmpty($item->count),
                $nullIfEmpty($item->flavored),
                $nullIfEmpty($item->seasonal),
                $item->inStock,
                $item->facebook,
                $item->isKCup,
            );
        }

        return $domainItems;
    }
}