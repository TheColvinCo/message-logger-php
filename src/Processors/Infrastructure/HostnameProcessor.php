<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Infrastructure;

use Colvin\MessageLogger\Processors\MessageProcessor;
use Colvin\CommonDomain\Domain\Message\Message;

final class HostnameProcessor implements MessageProcessor
{
    private string $host;

    public function __construct()
    {
        $this->host = \gethostname();
    }

    public function __invoke(array $record): array
    {
        $message = $record['context']['message'];

        if (false === $message instanceof Message) {
            return $record;
        }

        $record['extra']['hostname'] = $this->host;

        return $record;
    }
}
