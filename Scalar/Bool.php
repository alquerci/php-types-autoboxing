<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;

/**
 * It used to enforce strong typing of the bool type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class Bool extends Enum
{
    const FALSE = "";
    const TRUE = "1";

    /**
     * @return boolean
     */
    public function toBoolean()
    {
        if ($this->rawData === self::TRUE) {
            return true;
        }

        return false;
    }

    public function get()
    {
        return $this->toBoolean();
    }

    /**
     * @param boolean $value
     *
     * @return boolean
     */
    protected function fromBool($value)
    {
        if ($value === true) {
            $this->rawData = static::TRUE;
        } else {
            $this->rawData = static::FALSE;
        }

        return true;
    }

    /**
     * @param int $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        if ($value == 0) {
            $this->rawData = static::FALSE;
        } else {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @param array $value
     *
     * @return boolean
     */
    protected function fromArray($value)
    {
        if (count($value) == 0) {
            $this->rawData = static::FALSE;
        } else {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
    {
        if ($value == 0.0) {
            $this->rawData = static::FALSE;
        } else {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
        if ($value == "" or $value == "0") {
            $this->rawData = static::FALSE;
        } else {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @param object $value
     *
     * @return boolean
     */
    protected function fromObject($value)
    {
        $this->rawData = static::TRUE;

        if ($value instanceof \SimpleXMLElement) {
            $simpleXML = (bool) $value;

            if ($simpleXML) {
                $this->rawData = static::TRUE;
            } else {
                $this->rawData = static::FALSE;
            }
        }

        return true;
    }

    /**
     * @param resource $value
     *
     * @return boolean
     */
    protected function fromResource($value)
    {
        $this->rawData = static::TRUE;

        return true;
    }
}
