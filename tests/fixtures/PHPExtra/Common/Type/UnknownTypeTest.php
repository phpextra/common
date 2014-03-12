<?php
use PHPExtra\Type\Collection\Collection;
use PHPExtra\Type\Enum\Enum;
use PHPExtra\Type\UnknownType;

/**
 * The UnknownTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class UnknownTypeTest extends PHPUnit_Framework_TestCase
{
    public function testCreateNewUnknownWithNullValue()
    {
        $u = new UnknownType();
        $this->assertTrue($u->isNull());
        $this->assertNull($u->getValue());
    }

    public function testCreateNewUnknownWithStringValue()
    {
        $u = new UnknownType('string value');

        $this->assertTrue($u->isString());
        $this->assertTrue($u->isScalar());
        $this->assertFalse($u->isNull());
        $this->assertEquals('string value', $u->getAsString());
        $this->assertEquals('string value', $u->getValue());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetStringAsObjectThrowsException()
    {
        $u = new UnknownType('string value');
        $u->getAsObject();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetStringAsCollectionThrowsException()
    {
        $u = new UnknownType('string value');
        $u->getAsCollection();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetCollectionAsStringThrowsException()
    {
        $u = new UnknownType(new Collection());
        $u->getAsString();
    }

    public function testTestIfObjectIsCollectionReturnsTrueOnSuccess()
    {
        $u = new UnknownType(new Collection());
        $this->assertTrue($u->isCollection());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetObjectAsCollectionThrowsException()
    {
        $u = new UnknownType(new \stdClass());
        $u->getAsCollection();
    }

    public function testGetBooleanTrueAsBooleanReturnsTrue()
    {
        $u = new UnknownType(true);
        $this->assertTrue($u->getAsBool());
    }

    public function testGetObjectAsEnumReturnsEnum()
    {
        $u = new UnknownType(new EnumMock(1, true));
        $this->assertTrue($u->isEnum());
        $this->assertTrue($u->isObject());
        $this->assertFalse($u->isBoolean());
        $this->assertFalse($u->isScalar());
        $this->assertInstanceOf('PHPExtra\Type\Enum\EnumInterface', $u->getAsEnum());
    }


}
 