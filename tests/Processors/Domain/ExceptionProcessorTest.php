<?php

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\MessageLogger\Processors\Domain\ExceptionProcessor;
use Colvin\MessageLogger\Tests\Processors\AbstractProcessorTest;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;

class ExceptionProcessorTest extends AbstractProcessorTest
{
    private ExceptionProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new ExceptionProcessor();
    }

    public function testProcessException(): void
    {
        $value = 'c5b257aa-3050-4d38-aecc-1eae31a1032a';
        $exception = new LogicExceptionStub(Uuid::from($value));

        $record = [
            'context' => [
                'exception' => $exception,
            ],
        ];

        $recordReturned = $this->processor->__invoke($record);
        $exceptionRecord = $recordReturned['context']['exception'];
        self::assertArrayHasKey('class', $exceptionRecord);
        self::assertArrayHasKey('message', $exceptionRecord);
        self::assertArrayHasKey('code', $exceptionRecord);
        self::assertArrayHasKey('file', $exceptionRecord);
        self::assertArrayHasKey('line', $exceptionRecord);
        self::assertArrayHasKey('trace', $exceptionRecord);
        self::assertArrayHasKey('data', $exceptionRecord);
        self::assertSame(\json_encode(['id' => $value], JSON_THROW_ON_ERROR), $exceptionRecord['data']);
    }
}
