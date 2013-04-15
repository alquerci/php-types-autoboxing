<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Instinct\Component\TypeAutoBoxing\Scalar;

/**
 * It used to enforce strong typing of the unsigned integer type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class UInt extends Int
{
    /**
     * @param int $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        if ($value < 0) {
            $value = 0;
        }

        $this->rawData = $value;

        return true;
    }

    /**
     * @param bool $value
     *
     * @return boolean
     */
    protected function fromBool($value)
    {
        if ($value < 0) {
            $value = 0;
        }

        $this->rawData = (integer) $value;

        return true;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
    {
        if ($value < 0) {
            $value = 0;
        }

        $this->rawData = (integer) $value;

        return true;
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
        $value = (integer) $value;

        if ($value < 0) {
            $value = 0;
        }

        $this->rawData = $value;

        return true;
    }
}
