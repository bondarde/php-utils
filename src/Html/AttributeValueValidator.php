<?php

namespace BondarDe\Utils\Html;

class AttributeValueValidator
{
    public static function validate(string $value)
    {
        if (strpos($value, '"') === FALSE) {
            return;
        }

        throw new HtmlException('Invalid attribute value "' . $value . '"');
    }
}
