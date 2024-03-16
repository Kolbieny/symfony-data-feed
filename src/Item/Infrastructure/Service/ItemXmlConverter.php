<?php

declare(strict_types=1);

namespace App\Item\Infrastructure\Service;

use App\Item\Application\Service\ItemFileConverter;
use App\Item\Domain\Model\Item;
use App\Item\Infrastructure\Dto\CatalogXml;
use App\Item\Infrastructure\Mapper\ItemXmlMapper;
use App\Shared\Application\Exception\FileNotFoundException;
use JMS\Serializer\SerializerInterface;

final readonly class ItemXmlConverter implements ItemFileConverter
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * @return Item[]
     * @throws FileNotFoundException
     */
    public function convertFromFileToDomainModels(string $filePath): array
    {
        $fileContent = $this->getFileContentByPath($filePath);
        $catalog = $this->serializer->deserialize($fileContent, CatalogXml::class, 'xml');
        return ItemXmlMapper::multipleFromDtoToDomain($catalog->items);
    }

    /** @throws FileNotFoundException */
    public function getFileContentByPath(string $filePath): string
    {
        try {
            return file_get_contents($filePath);
        } catch (\Exception $exception) {
            throw new FileNotFoundException($filePath, $exception);
        }
    }
}