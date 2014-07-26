<?php

/**
 * EnumMock without default value
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EnumMock extends \PHPExtra\Type\Enum\AbstractEnum
{
    const VAL1 = 1;
    const VAL2 = 2;
    const VAL3 = 3;
}

/**
 * The EnumMock2 class with default value
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EnumMock2 extends EnumMock
{
    const _default = 3;
}

