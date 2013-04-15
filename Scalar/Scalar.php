<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Scalar;

use Instinct\Component\TypeAutoBoxing\ConvertibleInterface;
use Instinct\Component\TypeAutoBoxing\AutoBoxType;

/**
 * It used to enforce strong typing of the scalar type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
abstract class Scalar extends AutoBoxType implements ConvertibleInterface
{
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return boolean
     */
    public function toBoolean()
    {
        return (bool) $this->get();
    }

    /**
     * @return number
     */
    public function toInteger()
    {
        return (integer) $this->get();
    }

    /**
     * @return number
     */
    public function toDouble()
    {
        return (double) $this->get();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) $this->get();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (array) $this->get();
    }
}
