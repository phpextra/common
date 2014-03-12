<?php

namespace PHPExtra\Type\Object;

use Closure;
use PHPExtra\Type\UnknownType;

/**
 * The LazyObject class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class LazyObject implements LazyObjectInterface
{
    /**
     * @var Closure
     */
    protected $initializer;

    /**
     * @var bool
     */
    protected $isInitialized = false;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->initializer = $closure;
    }

    /**
     * Lazy load the value
     */
    protected function initialize()
    {
        if ($this->isInitialized == false) {
            $this->isInitialized = true;
            $this->value = call_user_func($this->initializer);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $this->initialize();

        return new UnknownType($this->value);
    }
}
