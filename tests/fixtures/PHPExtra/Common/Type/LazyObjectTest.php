<?php
use PHPExtra\Type\Object\LazyObject;

/**
 * The LazyObjectTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class LazyObjectTest extends PHPUnit_Framework_TestCase
{

    public function testCreateNewEmptyLazyObjectInstance()
    {
        $lazy = new LazyObject(function(){});
    }

    public function testCreateNewLazyObjectWithStringValue()
    {
        $lazy = new LazyObject(function(){return 'test1';});
        $this->assertEquals('test1', $lazy->get()->getAsString());
    }
}
 