<?php declare(strict_types=1);

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\CommonDomain\Application\Command;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;

final class CommandStub extends Command
{
    public static function create(array $payload = []): self
    {
        return self::fromPayload(
            Uuid::from('648fc611-b8d8-427c-8e08-c43d0c17cb3e'),
            $payload,
        );
    }

    public static function messageName(): string
    {
        return 'colvin.test.' . self::messageVersion() . '.' . self::messageType() . '.stub.bar';
    }

    public static function messageVersion(): string
    {
        return '1';
    }

    protected function assertPayload(): void
    {
        //nothing
    }
}