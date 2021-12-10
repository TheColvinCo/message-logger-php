<?php

declare(strict_types=1);

namespace Colvin\MessageLogger;

use Colvin\MessageLogger\Processors\MessageProcessor;
use Colvin\CommonDomain\Domain\Message\Message;
use Monolog\Processor\ProcessorInterface;

final class MessageLoggerProcessor implements ProcessorInterface
{
    private array $processors;

    public function __construct(MessageProcessor ...$processors)
    {
        $this->processors = $processors;
    }

    public function __invoke(array $record): array
    {
        if (false === $this->isMessageRecord($record)) {
            return $record;
        }

        return \array_reduce($this->processors, static fn ($carry, callable $arg) => $arg($carry), $record);
    }

    private function isMessageRecord(array $record): bool
    {
        if (false === \array_key_exists('context', $record)) {
            return false;
        }

        $context = $record['context'];

        if (false === \array_key_exists('message', $context)
            || false === $context['message'] instanceof Message) {
            return false;
        }

        if (false === \array_key_exists('name', $context)) {
            return false;
        }

        return true;
    }
}
