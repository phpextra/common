<?php

namespace PHPExtra\Type\Enum;

/**
 * The EnumInterface interface
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface EnumInterface
{
    /**
     * @return string
     */
    public function getValue();

    /**
     * @param EnumInterface $value
     *
     * @return bool
     */
    public function equals(EnumInterface $value);
}
