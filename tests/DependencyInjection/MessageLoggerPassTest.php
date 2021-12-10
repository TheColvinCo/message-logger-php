<?php

namespace Colvin\MessageLogger\Tests\DependencyInjection;

use Colvin\MessageLogger\DependencyInjection\MessageLoggerPass;
use Colvin\MessageLogger\Processors\Domain\ExceptionProcessor;
use Colvin\MessageLogger\Processors\Domain\MessageDataProcessor;
use Colvin\MessageLogger\Processors\Domain\NormalizeContextProcessor;
use Colvin\MessageLogger\Processors\Domain\OccurredOnProcessor;
use Colvin\MessageLogger\Processors\Infrastructure\HostnameProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MessageLoggerPassTest extends TestCase
{
    private MessageLoggerPass $messageLoggerPass;

    protected function setUp(): void
    {
        $this->messageLoggerPass = new MessageLoggerPass();
    }

    public function testProcess(): void
    {
        $container = new ContainerBuilder();

        $this->messageLoggerPass->process($container);

        self::assertTrue($container->hasDefinition(MessageLoggerPass::PROCESSOR_OCCURRED_ON));
        self::assertEquals(
            OccurredOnProcessor::class,
            $container->getDefinition(MessageLoggerPass::PROCESSOR_OCCURRED_ON)->getClass()
        );

        self::assertTrue($container->hasDefinition(MessageLoggerPass::PROCESSOR_HOSTNAME));
        self::assertEquals(
            HostnameProcessor::class,
            $container->getDefinition(MessageLoggerPass::PROCESSOR_HOSTNAME)->getClass()
        );

        self::assertTrue($container->hasDefinition(MessageLoggerPass::PROCESSOR_MESSAGE_DATA));
        self::assertEquals(
            MessageDataProcessor::class,
            $container->getDefinition(MessageLoggerPass::PROCESSOR_MESSAGE_DATA)->getClass()
        );

        self::assertTrue($container->hasDefinition(MessageLoggerPass::PROCESSOR_NORMALIZE_CONTEXT));
        self::assertEquals(
            NormalizeContextProcessor::class,
            $container->getDefinition(MessageLoggerPass::PROCESSOR_NORMALIZE_CONTEXT)->getClass()
        );

        self::assertTrue($container->hasDefinition(MessageLoggerPass::PROCESSOR_EXCEPTION));
        self::assertEquals(
            ExceptionProcessor::class,
            $container->getDefinition(MessageLoggerPass::PROCESSOR_EXCEPTION)->getClass()
        );
    }
}
