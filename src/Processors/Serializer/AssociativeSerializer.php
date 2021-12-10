<?php

declare(strict_types=1);

namespace Colvin\MessageLogger\Processors\Serializer;

final class AssociativeSerializer
{
    public static function from($element): array
    {
        return match (true) {
            $element instanceof \Throwable => self::throwable($element),
            \is_array($element) => \array_map(
                static function ($item) {
                    return self::from($item);
                },
                $element
            ),
            $element instanceof \JsonSerializable, \is_object($element) => self::basic($element),
            default => ['value' => $element],
        };
    }

    private static function throwable(\Throwable $throwable): array
    {
        return [
            'class' => \get_class($throwable),
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'trace' => $throwable->getTraceAsString(),
        ];
    }

    private static function basic($anything): array
    {
        return \json_decode(
            \json_encode(
                $anything,
                \JSON_THROW_ON_ERROR
            ),
            true,
            512,
            \JSON_THROW_ON_ERROR
        );
    }
}
