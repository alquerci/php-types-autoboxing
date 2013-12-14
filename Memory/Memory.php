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
    private static $entriesCount = 0;
    private static $lastAddress = 0;
    private static $registered = false;

    /**
     * @var array
     */
    private static $collection = array();

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
        if (self::$entriesCount % GarbageCollector::CYCLES_MAX === 0) {
            if (false === self::$registered) {
                GarbageCollector::register(self::$collection);
                self::$registered = true;
            }

            if (GarbageCollector::enabled()) {
                GarbageCollector::collect();
                self::$entriesCount = count(self::$collection);
            }
        }

        if (PHP_INT_MAX === self::$lastAddress) {
            do {
                $address = hash('sha1', uniqid(mt_rand(), true));
            } while (isset(self::$collection[$address]) || array_key_exists($address, self::$collection));
        } else {
            $address = ++self::$lastAddress;
        }

        self::$collection[$address] = &$value;
        ++self::$entriesCount;

        return $address;
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
        return self::$collection[$id];
    }

    /**
     * @param int|string $id
     *
     * @api
     */
    public static function free($id)
    {
        // This method is no-op if the id is unknown
        if (false === (isset(self::$collection[$id]) || array_key_exists($id, self::$collection))) {
            return;
        }

        unset(self::$collection[$id]);
        --self::$entriesCount;
    }
}
