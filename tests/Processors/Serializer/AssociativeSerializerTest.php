<?php

namespace Colvin\MessageLogger\Tests\Processors\Serializer;

use Colvin\MessageLogger\Processors\Serializer\AssociativeSerializer;
use Colvin\MessageLogger\Tests\Processors\Domain\CommandStub;
use Colvin\MessageLogger\Tests\Processors\Domain\LogicExceptionStub;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class AssociativeSerializerTest extends TestCase
{
    public function testSerializePrimitiveValue(): void
    {
        $value = 'foo';
        $result = AssociativeSerializer::from($value);
        self::assertSame(['value' => $value], $result);
    }

    public function testSerializeThrowable(): void
    {
        $value = new LogicExceptionStub(Uuid::from('67f05b91-b08e-4fda-8ea5-d9f18de04aac'));
        $result = AssociativeSerializer::from($value);

        self::assertArrayHasKey('class', $result);
        self::assertArrayHasKey('message', $result);
        self::assertArrayHasKey('code', $result);
        self::assertArrayHasKey('file', $result);
        self::assertArrayHasKey('line', $result);
        self::assertArrayHasKey('trace', $result);

        self::assertSame(LogicExceptionStub::class, $result['class']);
        self::assertSame($value->getMessage(), $result['message']);
        self::assertSame($value->getCode(), $result['code']);
        self::assertSame($value->getFile(), $result['file']);
        self::assertSame($value->getLine(), $result['line']);
        self::assertSame($value->getTraceAsString(), $result['trace']);
    }

    public function testSerializeJsonSerializable(): void
    {
        $value = CommandStub::create(['foo' => 'bar']);
        $result = AssociativeSerializer::from($value);
        self::assertSame(
            \json_decode(
                \json_encode(
                    $value,
                    JSON_THROW_ON_ERROR
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            ),
            $result
        );
    }

    public function testSerializerSimpleArray(): void
    {
        $value = ['foo' => ['bar' => 'baz']];
        $result = AssociativeSerializer::from($value);
        self::assertSame(['foo' => ['bar' => ['value' => 'baz']]], $result);
    }
}
