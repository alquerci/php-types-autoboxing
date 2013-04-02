<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;


/**
 * It used to enforce strong typing of the enum type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
abstract class Enum extends Scalar
{
    /**
     * @var string
     */
    protected $rawData;

    /**
     * @var string[]
     */
    protected static $constants;

    /**
     * @var array
     */
    private static $validClass = array();

    /**
     * @param string $method
     * @param array $args
     *
     * @return Enum
     *
     * @throws \BadMethodCallException
     */
    static public function __callStatic($method, $args)
    {
        $constList = static::getConstList();

        if (isset($constList[$method])) {
            return new static($constList[$method]);
        }

        throw new \BadMethodCallException();
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->toString();
    }

    protected function clear()
    {
        $constList = static::getConstList();
        $this->rawData = array_shift($constList);
    }

    /**
     * @param Boolean $value
     */
    protected function fromBool($value)
    {
        return $this->setMe($value);
    }

    /**
     * @param integer $value
     */
    protected function fromInt($value)
    {
        return $this->setMe($value);
    }

    /**
     * @param bouble $value
     */
    protected function fromDouble($value)
    {
        return $this->setMe($value);
    }

    /**
     * @param string $value
     */
    protected function fromString($value)
    {
        return $this->setMe($value);
    }

    /**
     * @return string[]
     *
     * @throws \LogicException
     */
    static public function getConstList()
    {
        if (self::$constants !== null) {
            return self::$constants;
        }

        $callClass = get_called_class();
        $refClass = new \ReflectionClass($callClass);
        $constList = $refClass->getConstants();

        if(in_array($callClass, self::$validClass)) {
            self::$constants = $constList;

            return $constList;
        }

        foreach ($constList as $const) {
            if (!is_string($const)) {
                $callClass = get_called_class();
                $message = "All constants of Class ".$callClass." must be ".
                           "strings. For use it into a switch and more.";

                throw new \LogicException($message);
            }
        }

        self::$validClass[] = $callClass;

        self::$constants = $constList;

        return $constList;
    }

    /**
     * @param mixed $value
     *
     * @return boolean
     */
    private function setMe($value)
    {
        $consts = static::getConstList();
        $index = array_search($value, $consts);

        if ($index !== false) {
            $this->rawData = $consts[$index];

            return true;
        } else {
            return false;
        }
    }
}