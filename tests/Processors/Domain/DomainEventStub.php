<?php declare(strict_types=1);

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\CommonDomain\Domain\DomainEvent;
use Colvin\CommonDomain\Domain\Model\ValueObject\DateTimeValueObject;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;

final class DomainEventStub extends DomainEvent
{
    public static function create(array $payload = []): self
    {
        return self::fromPayload(
            Uuid::from('648fc611-b8d8-427c-8e08-c43d0c17cb3e'),
            Uuid::from('8287b996-4033-414a-a7a5-6381160f2d93'),
            DateTimeValueObject::from('now'),
            $payload
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