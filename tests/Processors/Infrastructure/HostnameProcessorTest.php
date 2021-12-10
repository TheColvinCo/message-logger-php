<?php

namespace Colvin\MessageLogger\Tests\Processors\Infrastructure;

use Colvin\MessageLogger\Processors\Infrastructure\HostnameProcessor;
use Colvin\MessageLogger\Tests\Processors\AbstractProcessorTest;
use Colvin\MessageLogger\Tests\Processors\Domain\CommandStub;

class HostnameProcessorTest extends AbstractProcessorTest
{
    private HostnameProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new HostnameProcessor();
    }

    public function testHostnameProcessor(): void
    {
        $recordReturned = $this->processor->__invoke($this->getRecord(CommandStub::create()));
        self::assertArrayHasKey('hostname', $recordReturned['extra']);
    }
}
