<?php

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\MessageLogger\Processors\Domain\NormalizeContextProcessor;
use Colvin\MessageLogger\Tests\Processors\AbstractProcessorTest;
use PHPUnit\Framework\TestCase;

class NormalizeContextProcessorTest extends AbstractProcessorTest
{
    private NormalizeContextProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new NormalizeContextProcessor();
    }

    public function testProcess(): void
    {
        $message = CommandStub::create();
        $recordReturned = $this->processor->__invoke($this->getRecord($message));

        self::assertEquals(
            $recordReturned['context']['message'],
            \json_encode(
                [
                    'messageId' => $message->messageId()->value(),
                    'name' => $message::messageName(),
                    'version' => $message::messageVersion(),
                    'type' => $message::messageType(),
                    'payload' => $message->messagePayload(),
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
