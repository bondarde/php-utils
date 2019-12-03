<?php

namespace Bond211\Utils\Traits;

use ReflectionClass;
use ReflectionException;

trait HasConstantsList
{
    private static $cache = [];

    public static function getConstants(): array
    {
        $calledClass = get_called_class();

        self::fillConstantsListCache($calledClass);

        return self::$cache[$calledClass];
    }

    public static function hasConstant(string $name, bool $strict = true): bool
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    public static function hasConstantValue($value, bool $strict = true): bool
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }

    private static function fillConstantsListCache(string $calledClass): void
    {
        if (array_key_exists($calledClass, self::$cache)) {
            return;
        }

        $constants = self::toConstants($calledClass);

        self::$cache[$calledClass] = $constants;
    }

    private static function toConstants(string $calledClass): array
    {
        try {
            $reflect = new ReflectionClass($calledClass);
            $constants = $reflect->getConstants();
        } catch (ReflectionException $e) {
            $constants = [];
        }

        return $constants;
    }
}
