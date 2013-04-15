<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Composite;

use Instinct\Component\TypeAutoBoxing\AutoBoxType;

/**
 * It used to enforce strong typing of the composite type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
abstract class Composite extends AutoBoxType
{
    /**
     * @return string
     */
    public function __toString()
    {
        return get_called_class();
    }

    /**
     * @param object $value
     *
     * @return boolean
     */
    protected function fromObject($value)
    {
        if ($value instanceof \Traversable) {
            $array = array();
            $array = iterator_to_array($value, true);

            return $this->fromArray($array);
        }

        return false;
    }
}
