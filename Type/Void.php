<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Type;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
final class Void extends Type
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
    }

    /**
     * {@inheritDoc}
     */
    public function initialize($initialValue = null)
    {
        return $initialValue;
    }
}
