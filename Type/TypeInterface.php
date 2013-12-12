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
interface TypeInterface
{
    /**
     * Constructs a Type
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array());

    /**
     * @param mixed $initialValue
     *
     * @return mixed The initialized value
     */
    public function initialize($initialValue = null);

    /**
     * @param string $operator   TypeInterface::OP_*
     * @param &mixed $leftValue
     * @param mixed  $rightValue
     *
     * @return &mixed The resultant value
     */
    public function &operator($operator, &$leftValue, $rightValue = null);
}
