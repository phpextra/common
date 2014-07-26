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
    private $value;

    /**
     * @param string $value
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($value = null)
    {
        if(!$value && static::_default !== null){
            $value = static::_default;
        }

        if (!self::isValid($value)) {
            throw new \UnexpectedValueException(sprintf('Unexpected value "(%s)%s"', gettype($value), $value));
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
     * @param $value
     *
     * @return array
     */
    public static function isValid($value)
    {
        if($value === null){
            return false;
        }

        $reflection = new \ReflectionClass(get_called_class());
        return in_array($value, $reflection->getConstants());
    }

    /**
     * {@inheritdoc}
     */
    public function equals(EnumInterface $enum)
    {
        return $this->getValue() === $enum->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}
