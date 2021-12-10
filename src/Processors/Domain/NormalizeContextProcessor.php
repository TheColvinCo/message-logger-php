<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Domain;

use Colvin\MessageLogger\Processors\MessageProcessor;

final class NormalizeContextProcessor implements MessageProcessor
{
    public function __invoke(array $record): array
    {
        if (false === \is_string($record['context']['message'])) {
            $record['context']['message'] = \json_encode($record['context']['message'], \JSON_THROW_ON_ERROR);
        }

        return $record;
    }
}
