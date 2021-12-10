<?php

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\MessageLogger\Processors\Domain\OccurredOnProcessor;
use Colvin\MessageLogger\Tests\Processors\AbstractProcessorTest;
use Colvin\CommonDomain\Domain\Model\ValueObject\DateTimeValueObject;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class OccurredOnProcessorTest extends AbstractProcessorTest
{
    private OccurredOnProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new OccurredOnProcessor();
    }

    public function testNoMessageInstance(): void
    {
        $record = $this->getRecord('bar');

        $returnedRecord = $this->processor->__invoke($record);

        self::assertSame($record, $returnedRecord);
    }

    public function testDomainEventInstance(): void
    {
        $occurredOn = DateTimeValueObject::from('yesterday');

        $domainEvent = DomainEventStub::fromPayload(
            Uuid::from('8f55979e-edaa-4264-9db0-d8b3eda461ed'),
            Uuid::from('50c906eb-ab05-4057-b0fb-5484a0a988ab'),
            $occurredOn,
            []
        );

        $returnedRecord = $this->processor->__invoke($this->getRecord($domainEvent));

        self::assertArrayHasKey('occurredOn', $returnedRecord);
        self::assertEquals(
            $returnedRecord['occurredOn'],
            \sprintf(
                '%d%d',
                $occurredOn->getTimestamp(),
                $occurredOn->format('v')
            )
        );
    }

    public function testCommandInstance(): void
    {
        $command = CommandStub::fromPayload(
            Uuid::from('0cf7eedd-de7c-4556-a46e-7f35d9107725'),
            []
        );

        $returnedRecord = $this->processor->__invoke($this->getRecord($command));

        self::assertArrayHasKey('occurredOn', $returnedRecord);
        self::assertIsInt($returnedRecord['occurredOn']);
    }
}
