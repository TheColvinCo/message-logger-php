<?php declare(strict_types=1);

namespace Colvin\MessageLogger\Tests\Processors;

use PHPUnit\Framework\TestCase;

abstract class AbstractProcessorTest extends TestCase
{
    protected function getRecord(mixed $message): array
    {
        return [
            'context' => [
                'message' => $message,
            ],
        ];
    }
}