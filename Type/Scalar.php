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
class Scalar extends Type
{
    /**
     * {@inheritDoc}
     */
    protected function validateType($value)
    {
        if (!is_scalar($value) && null !== $value) {
            throw new \RuntimeException(sprintf('Expected scalar, but got %s.', gettype($value)));
        }
    }
}
