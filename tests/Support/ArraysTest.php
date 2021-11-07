<?php

namespace Tests\Support;

use BondarDe\Utils\Support\Arrays;
use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    const FLATTEN_KEYS_INPUT = [
        'key1' => 'val1',
        'key2' => [
            'key3' => 'val3',
            'key4' => 'val4',
            'key5' => [
                'key6' => 'val6',
            ],
        ],
    ];

    public function testFlattenKeysWithDefaultSeparator()
    {
        $res = Arrays::flattenKeys(self::FLATTEN_KEYS_INPUT);

        $expected = [
            'key1' => 'val1',
            'key2.key3' => 'val3',
            'key2.key4' => 'val4',
            'key2.key5.key6' => 'val6',
        ];

        self::assertEquals($expected, $res);
    }

    public function testFlattenKeysWithCustomSeparator()
    {
        $res = Arrays::flattenKeys(self::FLATTEN_KEYS_INPUT, '_');

        $expected = [
            'key1' => 'val1',
            'key2_key3' => 'val3',
            'key2_key4' => 'val4',
            'key2_key5_key6' => 'val6',
        ];

        self::assertEquals($expected, $res);
    }

    public function testFlattenKeysWithKeyPrefix()
    {
        $res = Arrays::flattenKeys(self::FLATTEN_KEYS_INPUT, '.', 'config');

        $expected = [
            'config.key1' => 'val1',
            'config.key2.key3' => 'val3',
            'config.key2.key4' => 'val4',
            'config.key2.key5.key6' => 'val6',
        ];

        self::assertEquals($expected, $res);
    }
}
