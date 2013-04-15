<?php

/*
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
class Memory
{
    /**
     * @var ReferenceCollection
     */
    private static $collection;

    /**
     * @api
     */
    private function __construct()
    {
    }

    /**
     * @param mixed $value
     *
     * @return integer|string
     *
     * @api
     */
    public static function alloc(&$value)
    {
        GarbageCollector::collect();

        return self::getCollection()->add($value);
    }

    /**
     * @param interger|string $id
     *
     * @return &mixed
     *
     * @api
     */
    public static function &get($id)
    {
        return self::getCollection()->get($id);
    }

    /**
     * @param int|string $id
     *
     * @api
     */
    public static function free($id)
    {
        self::getCollection()->remove($id);
    }

    /**
     * @return ReferenceCollection
     */
    private static function getCollection()
    {
        if (self::$collection === null) {
            self::$collection = new ReferenceCollection();

            // Register to the garbage collector
            $storage = &self::$collection->all();
            GarbageCollector::register($storage);
        }

        return self::$collection;
    }
}
