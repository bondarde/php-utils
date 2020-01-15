<?php

namespace Tests\Html;

use Bond211\Utils\Html\DOM;
use Bond211\Utils\Html\HtmlException;
use PHPUnit\Framework\TestCase;

final class DomTest extends TestCase
{
    public function testEmptyTag()
    {
        $s = DOM::div();

        $this->assertEquals('<div></div>', $s);
    }

    public function testAttributes()
    {
        $s = DOM::div(['x' => 'y']);

        $this->assertEquals('<div x="y"></div>', $s);
    }

    public function testContentWithoutAttributes()
    {
        $s = DOM::div('DOM element');

        $this->assertEquals('<div>DOM element</div>', $s);
    }

    public function testContentWithAttributes()
    {
        $s = DOM::div(['x' => 'y'], 'DOM element');

        $this->assertEquals('<div x="y">DOM element</div>', $s);
    }

    public function testNumericContentWithoutAttributes()
    {
        $s = DOM::div(123);
        $this->assertEquals('<div>123</div>', $s);

        $s = DOM::div(1.23);
        $this->assertEquals('<div>1.23</div>', $s);
    }

    public function testNumericContentWithAttributes()
    {
        $s = DOM::div(['x' => 'y'], 123);
        $this->assertEquals('<div x="y">123</div>', $s);

        $s = DOM::div(['x' => 'y'], 1.23);
        $this->assertEquals('<div x="y">1.23</div>', $s);
    }

    public function testAttributeValueWithDoubleQuoteShouldFail()
    {
        $this->expectException(HtmlException::class);

        DOM::div(['x' => '"y"']);
    }
}
