<?php

namespace PHPExtra\Type\Collection;

use Closure;

/**
 * The AbstractCollection class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
abstract class AbstractCollection implements CollectionInterface, \Serializable
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var bool
     */
    protected $readOnly = false;

    /**
     * @var array|mixed[]
     */
    protected $entities = array();

    /**
     * @param array $entities
     */
    public function __construct(array $entities = array())
    {
        $this->entities = $entities;
    }

    /**
     * @param boolean $readOnly
     *
     * @return $this
     */
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @deprecated use isReadOnly
     * @return boolean
     */
    public function getReadOnly()
    {
        return $this->isReadOnly();
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        if ($this->isReadOnly()) {
            throw new \RuntimeException('Collection is read only');
        }
        $this->entities[] = $entity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() == 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->entities);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->entities[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfRangeException(sprintf('Index out of range: "%s"', $offset));
        }

        return $this->entities[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($this->isReadOnly()) {
            throw new \RuntimeException('Collection is read only');
        }
        $this->entities[$offset] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->isReadOnly()) {
            throw new \RuntimeException('Collection is read only');
        }
        unset($this->entities[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        return $this->count() > 0 ? $this->offsetGet(0) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->count() > 0 ? $this->offsetGet($this->count() - 1) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->offsetGet($this->position);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(Closure $c)
    {
        $filtered = new Collection();
        $this->rewind();
        foreach ($this as $offset => $element) {
            if ($c($element, $offset) === true) {
                $filtered->add($element);
            }
        }
        $this->rewind();
        return $filtered;
    }

    /**
     * {@inheritdoc}
     */
    public function slice($offset = 0, $length = null)
    {
        $slice = array_slice($this->entities, $offset, $length);
        $collection = new Collection($slice);
        $collection->setReadOnly($this->isReadOnly());

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            'readonly' => $this->readOnly,
            'entities' => $this->entities
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->position = 0;
        $this->readOnly = $data['readonly'];
        $this->entities = $data['entities'];
    }
}
