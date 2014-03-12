<?php

namespace PHPExtra\Type\Enum;

/**
 * The Enum class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class Enum extends AbstractEnum
{
    /**
     * @param string $value
     * @param array $validValues
     */
    function __construct($value, array $validValues = null)
    {
        if($validValues !== null){
            $this->setValidValues($validValues);
        }
        parent::__construct($value);
    }
}
