<?php

namespace PHPExtra\Type;

use PHPExtra\Type\Collection\CollectionInterface;
use PHPExtra\Type\Enum\EnumInterface;

/**
 * The UnknownType class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class UnknownType
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    /**
     * Set RAW value
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get RAW value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @throws \RuntimeException
     * @return \stdClass
     */
    public function getAsObject()
    {
        if (!$this->isObject()) {
            throw new \RuntimeException('Value is not an object');
        }

        return $this->getValue();
    }

    /**
     * @throws \RuntimeException
     * @return string|int|float|bool
     */
    public function getAsScalar()
    {
        if (!$this->isScalar()) {
            throw new \RuntimeException('Value is not a scalar type');
        }

        return $this->getValue();
    }

    /**
     * @throws \RuntimeException
     * @return CollectionInterface
     */
    public function getAsCollection()
    {
        if (!$this->isCollection()) {
            throw new \RuntimeException('Value is not a collection');
        }

        return $this->getValue();
    }

    /**
     * @return string
     */
    public function getAsString()
    {
        return (string) $this->getAsScalar();
    }

    /**
     * @return bool
     */
    public function getAsBool()
    {
        return (bool) $this->getAsScalar();
    }

    /**
     * @throws \RuntimeException
     * @return EnumInterface
     */
    public function getAsEnum()
    {
        if (!$this->isEnum()) {
            throw new \RuntimeException('Value is not a scalar type');
        }

        return $this->getValue();
    }

    /**
     * @return bool
     */
    public function isEnum()
    {
        return $this->getValue() instanceof EnumInterface;
    }

    /**
     * @return bool
     */
    public function isCollection()
    {
        return $this->getValue() instanceof CollectionInterface;
    }

    /**
     * Tell that given unknown value can be sorted using SorterInterface
     *
     * @see SorterInterface
     * @return bool
     */
    public function isSortable()
    {
        return $this->getValue() instanceof SortableInterface;
    }

    /**
     * @return bool
     */
    public function isString()
    {
        $val = $this->getValue();

        return is_string($val);
    }

    /**
     * @return bool
     */
    public function isScalar()
    {
        $val = $this->getValue();

        return is_scalar($val);
    }

    /**
     * @return bool
     */
    public function isObject()
    {
        $val = $this->getValue();

        return is_object($val);
    }

    /**
     * @return bool
     */
    public function isBoolean()
    {
        $val = $this->getValue();

        return is_bool($val);
    }

    /**
     * @return bool
     */
    public function isException()
    {
        return $this->getValue() instanceof \Exception;
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return $this->getValue() === null;
    }
}
