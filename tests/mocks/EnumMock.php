<?php
use PHPExtra\Type\Enum\Enum;

/**
 * EnumMock
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EnumMock extends Enum
{
    const VAL1 = 1;
    const VAL2 = 2;
    const VAL3 = 3;

    /**
     * Force object validation
     *
     * @var bool
     */
    public $forceValid = false;

    /**
     * {@inheritdoc}
     */
    public function __construct($value, $forceValid = false)
    {
        $this->forceValid = $forceValid;
        parent::__construct($value);
    }
}