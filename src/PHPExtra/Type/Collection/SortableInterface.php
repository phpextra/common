<?php

namespace PHPExtra\Type\Collection;

use Closure;

/**
 * The Sortable interface
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface SortableInterface
{
    /**
     * @see uksort
     * @param Closure $callable Key comparision function
     *
     * @return CollectionInterface
     */
    public function sort(Closure $callable);
}