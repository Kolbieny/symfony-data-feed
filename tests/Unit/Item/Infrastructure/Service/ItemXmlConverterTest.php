<?php

declare(strict_types=1);

namespace App\Tests\Unit\Item\Infrastructure\Service;

use App\Item\Domain\Model\Item;
use App\Item\Infrastructure\Dto\CatalogXml;
use App\Item\Infrastructure\Dto\ItemXml;
use App\Item\Infrastructure\Service\ItemXmlConverter;
use App\Shared\Application\Exception\FileNotFoundException;
use JMS\Serializer\Exception\XmlErrorException;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ItemXmlConverterTest extends TestCase
{
    private SerializerInterface&MockObject $serializerMock;
    private ItemXmlConverter $converter;

    public function setUp(): void
    {
        $this->serializerMock = $this->createMock(SerializerInterface::class);
        $this->converter = new ItemXmlConverter($this->serializerMock);
    }

    public function testConvertFromFileToDomainModelWhenFileNotFoundThenExceptionIsThrown(): void
    {
        $this->serializerMock->expects($this->never())->method('deserialize');
        $this->expectException(FileNotFoundException::class);

        $this->converter->convertFromFileToDomainModels('not-existing-file.xyz');
    }

    public function testConvertFromFileToDomainModelWhenFileHasInvalidContentExceptionIsThrown(): void
    {
        $mockException = $this->createStub(XmlErrorException::class);
        $this->serializerMock
            ->expects($this->once())
            ->method('deserialize')
            ->willThrowException($mockException);
        $this->expectException(XmlErrorException::class);

        $this->converter->convertFromFileToDomainModels(__DIR__ . "/test-file.xml");
    }

    public function testConvertFromFileToDomainModelWhenProperFileThenReturnItem(): void
    {
        $itemXml = new ItemXml(
            1,
            'test',
            'test',
            'test',
            "",
            'test',
            1.01,
            'test',
            'test',
            'test',
            1,
            'test',
            1,
            'test',
            'test',
            'test',
            true,
            true,
        );
        $catalogXml = new CatalogXml([$itemXml]);

        $this->serializerMock
            ->expects($this->once())
            ->method('deserialize')
            ->willReturn($catalogXml);

        $items = $this->converter->convertFromFileToDomainModels(__DIR__ . "/test-file.xml");

        $this->assertCount(1, $items);
        $this->assertInstanceOf(Item::class, $items[0]);
        $this->assertEquals(1, $items[0]->id);
        $this->assertNull($items[0]->description);
    }
}