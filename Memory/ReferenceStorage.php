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
 */
class ReferenceStorage
{
    /**
     * @var array
     */
    private $storage;

    public function __construct()
    {
        $this->storage = array();
    }

    /**
     * @param mixed $value
     *
     * @return integer|string
     */
    public function add(&$value)
    {
        $id = $this->generateIdFor($value);

        $this->storage[$id] = &$value;

        return $id;
    }

    /**
     * @param integer|string $id
     *
     * @return mixed
     */
    public function &get($id)
    {
        return $this->storage[$id];
    }

    /**
     * @param integer|string $id
     */
    public function remove($id)
    {
        unset($this->storage[$id]);
    }

    /**
     * @return array
     */
    public function &all()
    {
        return $this->storage;
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
            } while(isset($this->storage[$id]) === false);
        }

        return $id;
    }
}
