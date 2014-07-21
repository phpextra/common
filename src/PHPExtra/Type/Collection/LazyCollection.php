<?php

namespace PHPExtra\Type\Collection;

use Closure;
use PHPExtra\Type\Object\LazyObjectInterface;
use PHPExtra\Type\UnknownType;

/**
 * The LazyCollection class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class LazyCollection extends Collection implements LazyObjectInterface
{
    /**
     * @var array
     */
    protected $entities = array();

    /**
     * @var Closure
     */
    protected $initializer;

    /**
     * @var bool
     */
    protected $isInitialized = false;

    /**
     * @param Closure $initializer
     */
    public function __construct(Closure $initializer = null)
    {
        if ($initializer !== null) {
            $this->setInitializer($initializer);
        }
        $this->setCollection(new Collection());
//        $this->setReadOnly(true);
    }

    /**
     * @return $this
     * @throws \RuntimeException
     */
    public function initialize()
    {
        if ($this->getInitializer() !== null && !$this->isInitialized) {
            $this->isInitialized = true;
            $collection = call_user_func($this->getInitializer());
            if (!$collection instanceof CollectionInterface) {
                throw new \RuntimeException(sprintf('Unexpected type given: %s', gettype($collection)));
            }
            $this->setCollection($collection);
        }

        return $this;
    }

    /**
     * @param Closure $initializer
     *
     * @return $this
     */
    public function setInitializer(Closure $initializer)
    {
        $this->initializer = $initializer;

        return $this;
    }

    /**
     * @return callable
     */
    public function getInitializer()
    {
        return $this->initializer;
    }

    /**
     * @param CollectionInterface $collection
     *
     * @return $this
     */
    public function setCollection(CollectionInterface $collection)
    {
        foreach($collection as $entity){
            $this->add($entity);
        }

        return $this;
    }

    /**
     * Get internally stored collection
     * This method is intended to access internal collection property
     * without initializing the object itself
     *
     * @deprecated will be removed in 1.2.0
     * @return CollectionInterface
     */
    public function getCollection()
    {
        // for keeping backwards comp.
        $collection = new Collection();
        foreach($this->entities as $entity){
            $collection->add($entity);
        }
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->initialize();

        return parent::getIterator();
    }

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return $this->isInitialized;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        $this->initialize();

        return parent::isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        if(!$this->isInitialized()){
            $this->initialize();
        }
        return parent::add($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->initialize();

        return parent::count();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->initialize();

        return parent::offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $this->initialize();

        return parent::offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function slice($offset = 0, $length = null)
    {
        $this->initialize();

        return parent::slice($offset, $length);
    }

    /**
     * {@inheritdoc}
     */
    public function sort(Closure $callable)
    {
        $this->initialize();
    }

    /**
     * Throwing exceptions should be done in __sleep
     * workaround for php not allowing to throw exception during serialize()
     * affects php 5.5, not visible in php 5.4
     *
     * @return string
     */
    public function serialize()
    {
        $this->initialize();
        $this->initializer = null;

        return parent::serialize();
    }

    /**
     * @param  string $serialized
     * @return void
     */
    public function unserialize($serialized)
    {
        $that = $this;
        $this->isInitialized = false;

        $this->initializer = function () use (&$serialized, &$that) {
            $data = unserialize($serialized);
            $that->setReadOnly($data['readonly']);

            $collection = new Collection();
            foreach($data['entities'] as $entity){
                $collection->add($entity);
            }

            return $collection;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $this->initialize();

        return new UnknownType($this->getCollection());
    }
}
