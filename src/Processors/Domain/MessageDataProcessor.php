<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Domain;

use Colvin\MessageLogger\Processors\MessageProcessor;
use Colvin\CommonDomain\Domain\Message\AggregateMessage;
use Colvin\CommonDomain\Domain\Message\Message;

final class MessageDataProcessor implements MessageProcessor
{
    public function __invoke(array $record): array
    {
        $message = $record['context']['message'];

        if (false === $message instanceof Message) {
            return $record;
        }

        $record = $this->messageData($record);

        return $this->aggregateData($record);
    }

    private function messageData(array $record): array
    {
        $message = $this->getMessage($record);

        $record['extra']['messageId'] = $message->messageId()->value();
        $record['extra']['name'] = $message::messageName();
        $record['extra']['type'] = $message::messageType();
        $record['extra']['payload'] = \json_encode($message->messagePayload(), \JSON_THROW_ON_ERROR);

        return $this->explodeAsyncApi($record, $message::messageName());
    }

    private function explodeAsyncApi(array $record, string $asyncApiName): array
    {
        $explodedName = \explode('.', $asyncApiName);

        $record['extra']['asyncapi']['organization'] = $explodedName[0] ?? '';
        $record['extra']['asyncapi']['service'] = $explodedName[1] ?? '';
        $record['extra']['asyncapi']['version'] = $explodedName[2] ?? '';
        $record['extra']['asyncapi']['type'] = $explodedName[3] ?? '';
        $record['extra']['asyncapi']['resource'] = $explodedName[4] ?? '';
        $record['extra']['asyncapi']['name'] = $explodedName[5] ?? '';

        return $record;
    }

    private function aggregateData(array $record): array
    {
        $message = $this->getMessage($record);

        if (false === $message instanceof AggregateMessage) {
            return $record;
        }

        $record['extra']['aggregateId'] = $message->aggregateId()->value();
        $record['extra']['occurredOn'] = $message->occurredOn()->format(\DateTimeInterface::ATOM);

        return $record;
    }

    private function getMessage(array $record): Message
    {
        return $record['context']['message'];
    }
}
