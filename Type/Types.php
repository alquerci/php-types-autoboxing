<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Type;

use Instinct\Component\TypeAutoBoxing\Exception\TypeNotFoundException;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
final class Types
{
    // scalar types
    const BOOLEAN   = 'boolean';
    const INTEGER   = 'integer';
    const DOUBLE    = 'double';
    const STRING    = 'string';

    // compound types
    const STORAGE   = 'array';
    const OBJECT    = 'object';

    // special types
    const RESOURCE  = 'resource';
    const VOID      = 'void';

    private static $typeMapping = null;

    /**
     * @var TypeInterface[]
     */
    private static $typeObjects = array();

    /**
     * @param Types::*|TypeInterface $name
     *
     * @return TypeInterface
     */
    public static function get($name)
    {
        if ($name instanceof TypeInterface) {
            return $name;
        }

        if (null === self::$typeMapping) {
            self::initializeTypeMapping();
        }

        $name = strtolower($name);

        if (!isset(self::$typeObjects[$name])) {
            if (!isset(self::$typeMapping[$name])) {
                if (!$name) {
                    throw new TypeNotFoundException($name);
                }

                $alternatives = array();
                foreach (array_keys(self::$typeMapping) as $key) {
                    $lev = levenshtein($name, $key);
                    if ($lev <= strlen($name) / 3 || false !== strpos($key, $name)) {
                        $alternatives[] = $key;
                    }
                }

                throw new TypeNotFoundException($name, null, $alternatives);
            }

            self::$typeObjects[$name] = new self::$typeMapping[$name]();
        }

        return self::$typeObjects[$name];
    }

    /**
     * Resolve the type from a value
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function resolve($value)
    {
        return gettype($value);
    }

    private static function initializeTypeMapping()
    {
        self::$typeMapping = array(
            // scalar types
            self::BOOLEAN   => __NAMESPACE__.'\\Boolean',
            self::INTEGER   => __NAMESPACE__.'\\Integer',
            self::DOUBLE    => __NAMESPACE__.'\\Double',
            self::STRING    => __NAMESPACE__.'\\String',

            // compound types
            self::STORAGE   => __NAMESPACE__.'\\Storage',
            self::OBJECT    => __NAMESPACE__.'\\Object',

            // special types
            self::RESOURCE  => __NAMESPACE__.'\\Resource',
            self::VOID      => __NAMESPACE__.'\\Void',
        );
    }
}
