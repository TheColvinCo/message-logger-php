<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Domain;

use Colvin\MessageLogger\Processors\MessageProcessor;
use Colvin\CommonDomain\Domain\DomainEvent;
use Colvin\CommonDomain\Domain\Message\Message;

final class OccurredOnProcessor implements MessageProcessor
{
    public function __invoke(array $record): array
    {
        $message = $record['context']['message'];

        if (false === $message instanceof Message) {
            return $record;
        }

        if ($message instanceof DomainEvent) {
            $occurredOn = \sprintf(
                '%d%d',
                $message->occurredOn()->getTimestamp(),
                $message->occurredOn()->format('v')
            );
            $record['occurredOn'] = (int) $occurredOn;

            return $record;
        }

        $record['occurredOn'] = (int) \round(\microtime(true) * 1000);

        return $record;
    }
}
