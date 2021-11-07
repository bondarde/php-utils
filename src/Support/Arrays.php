<?php

namespace BondarDe\Utils\Support;

class Arrays
{
    public static function flattenKeys(array $arr, string $keyGlue = '.', string $keyPrefix = ''): array
    {
        $res = [];

        foreach ($arr as $key => $val) {
            if ($keyPrefix) {
                $key = $keyPrefix . $keyGlue . $key;
            }

            if (gettype($val) === 'array') {
                $tmp = self::flattenKeys($val, $keyGlue, $key);
                $res = array_merge($res, $tmp);
            } else {
                $res[$key] = $val;
            }
        }

        return $res;
    }
}
