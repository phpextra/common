<?php

namespace PHPExtra\Common;

/**
 * Allows converting objects to arrays
 */
interface ToArrayInterface
{
    /**
     * Convert object to an array
     *
     * @return array
     */
    public function toArray();
}