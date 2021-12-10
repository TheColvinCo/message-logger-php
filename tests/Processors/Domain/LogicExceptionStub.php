<?php declare(strict_types=1);

namespace Colvin\MessageLogger\Tests\Processors\Domain;

use Colvin\CommonDomain\Domain\Exception\LogicException;
use Colvin\CommonDomain\Domain\Model\ValueObject\Uuid;
use Throwable;

final class LogicExceptionStub extends LogicException
{
    public function __construct(private Uuid $example)
    {
        parent::__construct('Message stub');
    }

    public function data(): array
    {
        return [
            'id' => $this->example->value(),
        ];
    }
}