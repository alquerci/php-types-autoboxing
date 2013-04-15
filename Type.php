<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing;

/**
 * Extend it to enforce strong typing.
 *
 * @author alexandre.quercia
 */
abstract class Type
{
    /**
     * @param mixed $value [Optional]
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($value = null)
    {
        $this->set($value);
    }

    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    final public function set($value)
    {
        $isValid = false;

        if ($value === null) {
            $this->clear();

            $isValid = true;
        } elseif (is_object($value)) {
            $isValid = $this->fromObject($value);
        } elseif (is_bool($value)) {
            $isValid = $this->fromBool($value);
        } elseif (is_int($value)) {
            $isValid = $this->fromInt($value);
        } elseif (is_double($value)) {
            $isValid = $this->fromDouble($value);
        } elseif (is_string($value)) {
            $isValid = $this->fromString($value);
        } elseif (is_array($value)) {
            $isValid = $this->fromArray($value);
        } elseif (is_resource($value)) {
            $isValid = $this->fromResource($value);
        }

        if (!$isValid) {
            throw new \UnexpectedValueException(sprintf(
                'The value of type "%s" could not be converted to "%s".',
                gettype($value),
                get_called_class()
            ));
        }
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
        return false;
    }

    /**
     * @param object $value
     *
     * @return boolean
     */
    protected function fromObject($value)
    {
        return false;
    }

    /**
     * @param boolean $value
     *
     * @return boolean
     */
    protected function fromBool($value)
    {
        return false;
    }

    /**
     * @param integer $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        return false;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
    {
        return false;
    }

    /**
     * @param array $value
     *
     * @return boolean
     */
    protected function fromArray($value)
    {
        return false;
    }

    /**
     * @param resource $value
     *
     * @return boolean
     */
    protected function fromResource($value)
    {
        return false;
    }

    /**
     * Returns a php native representation
     *
     * @return mixed
     */
    abstract public function get();

    /**
     * Clear the value.
     */
    abstract protected function clear();
}
