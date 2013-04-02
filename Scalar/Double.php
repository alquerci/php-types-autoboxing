<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;


/**
 * It used to enforce strong typing of the double type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
class Double extends Scalar
{
    /**
     * @var double
     */
    private $rawData;

    protected function clear()
    {
        $this->rawData = (double) 0;
    }

    public function get()
    {
        return $this->rawData;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
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
        $this->rawData = (double) $value;

        return true;
    }

    /**
     * @param integer $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        $this->rawData = (double) $value;

        return true;
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
        $this->rawData = (double) $value;

        return true;
    }
}
