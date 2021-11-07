<?php

namespace BondarDe\Utils\Html;

class DOM
{
    const VOID_ELEMENTS = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    public static function __callStatic($tagName, $arguments)
    {
        $config = RenderConfig::fromArguments($tagName, $arguments);

        return self::render($tagName, $config->attributes, $config->content, $config->hasClosingTag);
    }


    private static function render(string $tagName, array $attr = [], string $content = '', bool $close = true): string
    {
        $attrStr = self::toAttributesString($attr);

        $res = '<' . trim($tagName . ' ' . $attrStr) . '>';
        if ($close) {
            $res .= $content . '</' . $tagName . '>';
        }

        return $res;
    }

    private static function toAttributesString(array $attr)
    {
        $attrMapper = function ($key, $val) {
            AttributeValueValidator::validate($val);
            return $key . '="' . $val . '"';
        };
        $attr = array_map($attrMapper, array_keys($attr), $attr);

        return implode(' ', $attr);
    }
}
