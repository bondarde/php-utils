<?php

namespace BondarDe\Utils\Html;

class RenderConfig
{
    public $tagName;
    public $attributes = [];
    public $content = '';
    public $hasClosingTag = true;

    public function __construct(string $tagName)
    {
        if (!$tagName) {
            return;
        }

        $this->tagName = $tagName;
        $this->hasClosingTag = !in_array($tagName, DOM::VOID_ELEMENTS);
    }

    public static function fromArguments(string $tagName, array $arguments): self
    {
        $config = new RenderConfig($tagName);

        $argumentsCount = count($arguments);
        switch ($argumentsCount) {
            case 0:
                break;
            case 1:
                $data = self::toPropertiesFromSingleArgument($arguments[0]);
                $config->attributes = $data['attributes'];
                $config->content = $data['content'];
                break;
            case 2:
                $data = self::toPropertiesFromTwoArguments($arguments[0], $arguments[1]);
                $config->attributes = $data['attributes'];
                $config->content = $data['content'];

                break;
            default:
                throw new HtmlException("Max. 2 arguments allowed, received $argumentsCount.");
        }

        return $config;
    }

    private static function toPropertiesFromSingleArgument($argument): array
    {
        $data = [
            'attributes' => [],
            'content' => '',
        ];

        $argumentType = gettype($argument);
        switch ($argumentType) {
            case 'array':
                $data['attributes'] = $argument;
                break;
            case 'string':
            case 'integer':
            case 'double':
                $data['content'] = $argument;
                break;
            default:
                throw new HtmlException("Argument expected to be string, integer or double, received $argumentType.");
        }

        return $data;
    }

    private static function toPropertiesFromTwoArguments($attributes, $content): array
    {
        $firstArgumentType = gettype($attributes);
        $secondArgumentType = gettype($content);

        if ($firstArgumentType !== 'array') {
            throw new HtmlException("First argument expected to be an array, received $firstArgumentType.");
        }
        if (!in_array($secondArgumentType, ['string', 'integer', 'double'])) {
            throw new HtmlException("Second argument expected to be a string, integer or double, received $secondArgumentType.");
        }

        return compact('attributes', 'content');
    }
}
