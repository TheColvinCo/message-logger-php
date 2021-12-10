<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\DependencyInjection;

use Colvin\MessageLogger\Processors\Domain\ExceptionProcessor;
use Colvin\MessageLogger\Processors\Domain\MessageDataProcessor;
use Colvin\MessageLogger\Processors\Domain\NormalizeContextProcessor;
use Colvin\MessageLogger\Processors\Domain\OccurredOnProcessor;
use Colvin\MessageLogger\Processors\Infrastructure\HostnameProcessor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class MessageLoggerPass implements CompilerPassInterface
{
    public const PROCESSOR_OCCURRED_ON = 'colvin.message_logger.processor.occurred_on';
    public const PROCESSOR_HOSTNAME = 'colvin.message_logger.processor.hostname';
    public const PROCESSOR_MESSAGE_DATA = 'colvin.message_logger.processor.message_data';
    public const PROCESSOR_NORMALIZE_CONTEXT = 'colvin.message_logger.processor.normalize_context';
    public const PROCESSOR_EXCEPTION = 'colvin.message_logger.processor.exception';

    public function process(ContainerBuilder $container): void
    {
        $container->addDefinitions(
            [
                self::PROCESSOR_OCCURRED_ON => new Definition(
                    OccurredOnProcessor::class
                ),
                self::PROCESSOR_HOSTNAME => new Definition(
                    HostnameProcessor::class
                ),
                self::PROCESSOR_MESSAGE_DATA => new Definition(
                    MessageDataProcessor::class
                ),
                self::PROCESSOR_NORMALIZE_CONTEXT => new Definition(
                    NormalizeContextProcessor::class
                ),
                self::PROCESSOR_EXCEPTION => new Definition(
                    ExceptionProcessor::class
                ),
            ]
        );
    }
}
