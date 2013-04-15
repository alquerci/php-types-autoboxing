<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;

/**
 * It used to enforce strong typing of the string type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class String extends Scalar
{
    /**
     * @var string
     */
    private $rawData;

    protected function clear()
    {
        $this->rawData = "";
    }

    public function get()
    {
        return $this->rawData;
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
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
        $this->rawData = (string) $value;

        return true;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
    {
        $this->rawData = (string) $value;

        return true;
    }

    /**
     * @param int $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        $this->rawData = (string) $value;

        return true;
    }

    /**
     * @param resource $value
     *
     * @return boolean
     */
    protected function fromResource($value)
    {
        $this->rawData = (string) $value;

        return true;
    }

    /**
     * @param object $value
     *
     * @return boolean
     */
    protected function fromObject($value)
    {
        if (method_exists($value, "__toString")) {
            $this->rawData = (string) $value;

            return true;
        }

        return false;
    }
}
