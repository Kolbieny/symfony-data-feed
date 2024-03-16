<?php

declare(strict_types=1);

namespace App\Item\Infrastructure\Dto;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlRoot;

#[XmlRoot('catalog')]
final readonly class CatalogXml
{
    public function __construct(
        #[XmlList(entry: 'item', inline: true)]
        #[Type('array<' . ItemXml::class . '>')]
        public array $items = []
    ) {
    }
}