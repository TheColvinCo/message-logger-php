<?php

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\MessageLogger\Processors\Domain\MessageDataProcessor;
use Colvin\MessageLogger\Tests\Processors\AbstractProcessorTest;
use Colvin\CommonDomain\Domain\Message\Message;
use PHPUnit\Framework\TestCase;

class MessageDataProcessorTest extends AbstractProcessorTest
{
    private MessageDataProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new MessageDataProcessor();
    }

    public function testProcessDomainEvent(): void
    {
        $message = DomainEventStub::create(
            ['foo' => 'baz'],
        );

        $recordReturned = $this->processor->__invoke($this->getRecord($message));
        $this->assertMessageRecord($message, $recordReturned);
        self::assertSame($message->aggregateId()->value(), $recordReturned['extra']['aggregateId'] ?? null);
        self::assertSame(
            $message->occurredOn()->format(\DateTimeInterface::ATOM),
            $recordReturned['extra']['occurredOn'] ?? null
        );
    }

    public function testProcessCommand()
    {
        $message = CommandStub::create(
            ['foo' => 'baz'],
        );
        $recordReturned = $this->processor->__invoke($this->getRecord($message));
        $this->assertMessageRecord($message, $recordReturned);
        self::assertArrayNotHasKey('aggregateId', $recordReturned['extra']);
        self::assertArrayNotHasKey('occurredOn', $recordReturned['extra']);
    }

    private function assertMessageRecord(Message $message, array $recordReturned)
    {
        self::assertArrayHasKey('extra', $recordReturned);
        $extra = $recordReturned['extra'];
        self::assertSame($message::messageName(), $extra['name'] ?? null);
        self::assertSame($message::messageType(), $extra['type'] ?? null);
        self::assertSame(
            \json_encode(
                $message->messagePayload(),
                JSON_THROW_ON_ERROR
            ),
            $extra['payload'] ?? null
        );

        $asyncApi = \explode('.', $message::messageName());
        self::assertSame($asyncApi[0], $extra['asyncapi']['organization']);
        self::assertSame($asyncApi[1], $extra['asyncapi']['service']);
        self::assertSame($asyncApi[2], $extra['asyncapi']['version']);
        self::assertSame($asyncApi[3], $extra['asyncapi']['type']);
        self::assertSame($asyncApi[4], $extra['asyncapi']['resource']);
        self::assertSame($asyncApi[5], $extra['asyncapi']['name']);
    }
}
