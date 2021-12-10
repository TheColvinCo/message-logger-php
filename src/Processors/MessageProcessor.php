<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors;

interface MessageProcessor
{
    public function __invoke(array $record): array;
}
