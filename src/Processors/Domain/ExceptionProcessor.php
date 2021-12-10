<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Domain;

use Colvin\MessageLogger\Processors\MessageProcessor;
use Colvin\MessageLogger\Processors\Serializer\AssociativeSerializer;

final class ExceptionProcessor implements MessageProcessor
{
    public function __invoke(array $record): array
    {
        if (false === \array_key_exists('exception', $record['context'])) {
            return $record;
        }

        $exception = $record['context']['exception'];
        $record['context']['exception'] = AssociativeSerializer::from($record['context']['exception']);

        if ($exception instanceof \JsonSerializable) {
            $record['context']['exception']['data'] = \json_encode($exception, \JSON_THROW_ON_ERROR);
        }

        if (true === \array_key_exists('trace', $record['context']['exception'])) {
            $record['context']['exception']['trace'] = \json_encode(
                $record['context']['exception']['trace'],
                \JSON_THROW_ON_ERROR
            );
        }

        return $record;
    }
}
