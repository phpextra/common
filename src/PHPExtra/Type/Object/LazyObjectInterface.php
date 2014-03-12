<?php

namespace PHPExtra\Type\Object;

use PHPExtra\Type\UnknownType;

/**
 * The LazyObjectInterface interface
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface LazyObjectInterface
{
    /**
     * @return UnknownType
     */
    public function get();
}
