<?php

/**
 * EnumTest
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EnumTest extends PHPUnit_Framework_TestCase
{

    public function testCreateEnumReturnsEnumWithValidValue()
    {
        $enum = new EnumMock(EnumMock::VAL1);

        $this->assertEquals(EnumMock::VAL1, $enum->__toString());
        $this->assertEquals(EnumMock::VAL1, $enum->getValue());
        $this->assertEquals((string)EnumMock::VAL1, (string)$enum);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateEnumWithInvalidValueThrowsInvalidArgumentException()
    {
        $enum = new EnumMock(15);
    }
}
 