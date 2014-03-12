<?php

namespace PHPExtra\Type\Collection;

use Closure;

/**
 * The CollectionInterface interface
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface CollectionInterface extends \Countable, \ArrayAccess, \Iterator
{
    /**
     * @param mixed $entity
     *
     * @return $this
     */
    public function add($entity);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * Return collection of elements that matched the filter
     * Filter takes two arguments - the element and its index.
     *
     * @param  Closure             $c
     * @return CollectionInterface
     */
    public function filter(Closure $c);

    /**
     * Extract a slice of the collection
     *
     * @param int $offset
     * @param int $length
     *
     * @return $this
     */
    public function slice($offset = 0, $length = null);
}
