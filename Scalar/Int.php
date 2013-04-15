<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;


/**
 * It used to enforce strong typing of the integer type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class Int extends Scalar
{
    /**
     * @var int
     */
    protected $rawData;

    protected function clear()
    {
        $this->rawData = 0;
    }

    /**
     * @return integer
     */
    public function get()
    {
        return $this->rawData;
    }

    /**
     * @param integer $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        $this->rawData = $value;

        return true;
    }

    /**
     * @param boolean $value
     *
     * @return boolean
     */
    protected function fromBool($value)
    {
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
        $this->rawData = (integer) $value;

        return true;
    }
}
