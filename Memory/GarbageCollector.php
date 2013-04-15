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
class GarbageCollector
{
    const CYCLES_MAX = 10000;

    /**
     * @var &array[]
     */
    private static $storages = array();

    /**
     * @var integer
     */
    private static $cycleCount = 0;

    /**
     * @var integer
     */
    private static $enable = true;

    /**
     * @api
     */
    private function __construct()
    {
    }

    /**
     * @api
     */
    public static function enable()
    {
        self::$enable = true;
    }

    /**
     * @api
     */
    public static function disable()
    {
        self::$enable = false;
    }

    /**
     * @param array $storage
     *
     * @api
     */
    public static function register(array &$storage)
    {
        self::$storages[] = &$storage;
    }

    /**
     * Forces collection of any existing garbage cycles
     *
     * @api
     */
    public static function collect()
    {
        if (!self::$enable) {
            return;
        }

        self::$cycleCount++;

        if (self::CYCLES_MAX <= self::$cycleCount) {
            self::$cycleCount = 0;

            foreach (array_keys(self::$storages) as $id) {
                self::doCollect($id);
            }
        }
    }

    /**
     * Forces collection of any existing garbage cycles
     */
    private static function doCollect($id)
    {
        $keys = array_keys(self::$storages[$id]);
        reset($keys);

        while (list(,$address) = each($keys)) {
            if (isset(self::$storages[$id][$address])) {
                if (self::refCount(self::$storages[$id][$address]) === 0) {
                    // destruct the object
                    unset(self::$storages[$id][$address]);
                }
            }
        }
    }

    /**
     * Return the reference count of a variable.
     * Returns 0 if a variable has no reference other than itself
     * or doesn't exist.
     *
     * @link http://www.php.net/manual/fr/function.debug-zval-dump.php#109146
     *
     * @param mixed $var
     *
     * @return number
     */
    private static function refCount(&$var)
    {
        ob_start();
        debug_zval_dump(array(&$var));
        $output = ob_get_clean();

        $sub = substr($output, 24);
        $pattern = '/^.+?refcount\((\d+)\).+$/ms';
        $nbref = preg_replace($pattern, '$1', $sub, 1);

        return $nbref - 4;
    }
}
