<?php
declare(strict_types=1);

namespace Tests\Traits;

use Bond211\Utils\Traits\HasConstantsList;
use PHPUnit\Framework\TestCase;

class ClassWithConstants
{
    use HasConstantsList;

    const VALUE_1 = 1;
    const VALUE_2 = 2;
}

final class HasConstantsListTest extends TestCase
{
    public function testConstantsList(): void
    {
        $constants = ClassWithConstants::getConstants();

        $expected = [
            'VALUE_1' => 1,
            'VALUE_2' => 2,
        ];

        $this->assertEquals($expected, $constants);
    }

    public function testConstantPresence(): void
    {
        $present = ClassWithConstants::hasConstant('VALUE_1');
        $this->assertTrue($present, 'Constant name should strictly match');

        $present = ClassWithConstants::hasConstant('value_1');
        $this->assertFalse($present, 'Low-case constant name should fail');

        $present = ClassWithConstants::hasConstant('VALUE_999');
        $this->assertFalse($present, 'Absent constant name should strictly fail');

        $present = ClassWithConstants::hasConstant('value_1', false);
        $this->assertTrue($present, 'Non-strict constant name matching');
    }

    public function testValuePresence(): void
    {
        $present = ClassWithConstants::hasConstantValue(1);
        $this->assertTrue($present, 'Constant value should strictly match');

        $present = ClassWithConstants::hasConstantValue('1');
        $this->assertFalse($present, 'Constant value should strictly fail');

        $present = ClassWithConstants::hasConstantValue('1', false);
        $this->assertTrue($present, 'Constant value should match non-strictly');

        $present = ClassWithConstants::hasConstantValue(999);
        $this->assertFalse($present, 'Absent value should fail strictly');

        $present = ClassWithConstants::hasConstantValue(999, false);
        $this->assertFalse($present, 'Absent value should fail non-strictly');
    }
}
