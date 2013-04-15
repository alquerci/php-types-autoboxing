<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing;

/**
 * Defines methods for converting an object into a php native type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
interface ConvertibleInterface
{
    /**
     * @return boolean
     *
     * @api
     */
    public function toBoolean();

    /**
     * @return integer
     *
     * @throws \RangeException If the value is outside the domain
     *     PHP_INT_MAX and ~PHP_INT_MAX
     *
     * @api
    */
    public function toInteger();

    /**
     * @return double
     *
     * @throws \RangeException If the converted value worth (-)INF
     *
     * @api
    */
    public function toDouble();

    /**
     * @return string
     *
     * @api
     */
    public function toString();

    /**
     * @return array
     *
     * @api
     */
    public function toArray();
}
