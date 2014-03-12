<?php

namespace PHPExtra\Common;

/**
 * The ToArrayInterface interface
 * Object implementing this interface is able to transform into array
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface ToArrayInterface
{
    /**
     * Transform object to an array
     *
     * @return array
     */
    public function toArray();
}