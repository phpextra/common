<?php

namespace PHPExtra\Type\Enum;

/**
 * AbstractEnum
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
abstract class AbstractEnum implements EnumInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected $validValues = array();

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            $validValues = implode(', ', $this->getValidValues());
            throw new \InvalidArgumentException(sprintf('Invalid value ("%s"), must be one of: %s', (string)$value, $validValues));
        }
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isValid($value)
    {
        return in_array($value, $this->getValidValues());
    }

    /**
     * @param array $validValues
     *
     * @return $this
     */
    public function setValidValues(array $validValues)
    {
        $this->validValues = $validValues;

        return $this;
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        if(empty($this->validValues)){
            $reflection = new \ReflectionClass(get_class($this));
            $this->setValidValues($reflection->getConstants());
        }
        return $this->validValues;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}
