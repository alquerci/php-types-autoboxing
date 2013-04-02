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
 */
class Memory
{
    /**
     * @var ReferenceStorage
     */
    private static $storage;

    /**
     */
    private function __construct()
    {
    }

    /**
     * @param mixed $value
     *
     * @return integer|string
     */
    public static function alloc(&$value)
    {
        GarbageCollector::collect();

        return self::getStorage()->add($value);
    }

    /**
     * @param interger|string $id
     *
     * @return &mixed
     */
    public static function &getReferenceById($id)
    {
        return self::getStorage()->get($id);
    }

    public static function free($id)
    {
        self::getStorage()->remove($id);
    }

    /**
     * @return ReferenceStorage
     */
    private static function getStorage()
    {
        if (self::$storage === null) {
            self::$storage = new ReferenceStorage();

            // Register to the garbage collector
            $storage = &self::$storage->all();
            GarbageCollector::register($storage);
        }

        return self::$storage;
    }
}
