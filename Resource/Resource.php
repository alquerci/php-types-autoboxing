<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Resource;

use Instinct\Component\TypeAutoBoxing\AutoBoxType;

/**
 * It used to enforce strong typing of the resource type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class Resource extends AutoBoxType
{
    private $rawData;

    protected function clear()
    {
        $this->rawData = null;
    }

    public function get()
    {
        return $this->rawData;
    }

    /**
     * @param resource $value
     *
     * @return boolean
     */
    protected function fromResource($value)
    {
        $this->rawData = $value;

        return true;
    }
}
