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

        $this->assertEquals(EnumMock::VAL1, $enum->getValue());
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testCreateEnumWithInvalidValueThrowsException()
    {
        new EnumMock(15);
    }

    public function testCreateEnumWithoutConstructorArgWillUseDefaultEnumValue()
    {
        $enum = new EnumMock2();
        $this->assertEquals(EnumMock2::VAL3, $enum->getValue());
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testCreateEnumWithoutDefaultValueAndConstructorArgThrowsException()
    {
        new EnumMock();
    }
}
 