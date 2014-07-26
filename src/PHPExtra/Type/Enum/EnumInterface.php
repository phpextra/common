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
     * Default value for this enum
     */
    const _default = null;

    /**
     * Get string value of this enum
     *
     * @return string
     */
    public function getValue();

    /**
     * Tell if given enum is equal
     *
     * @param EnumInterface $value
     *
     * @return bool
     */
    public function equals(EnumInterface $value);
}
