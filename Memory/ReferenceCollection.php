<?php

/*
 * This file is part of the Instinct package.
 *
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Memory;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class ReferenceCollection
{
    /**
     * @var array
     */
    private $collection;

    /**
     * @api
     */
    public function __construct()
    {
        $this->collection = array();
    }

    /**
     * @param mixed $value
     *
     * @return integer|string
     *
     * @api
     */
    public function add(&$value)
    {
        $id = $this->generateIdFor($value);

        $this->collection[$id] = &$value;

        return $id;
    }

    /**
     * @param integer|string $id
     *
     * @return mixed
     *
     * @api
     */
    public function &get($id)
    {
        return $this->collection[$id];
    }

    /**
     * @param integer|string $id
     *
     * @api
     */
    public function remove($id)
    {
        unset($this->collection[$id]);
    }

    /**
     * @return array
     *
     * @api
     */
    public function &all()
    {
        return $this->collection;
    }

    /**
     * @param mixed $value
     *
     * @return integer|string
     */
    private function generateIdFor($value)
    {
        if (is_object($value)) {
            $id = spl_object_hash($value);
        } else {
            $id = -1;

            do {
                $id++;
            } while (isset($this->collection[$id]) === false);
        }

        return $id;
    }
}
